<?php

use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProfileController;
use App\Models\Pizza;
use App\Models\Role;
use App\Models\Status;
use App\Models\Topping;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => 'auth'], function () {
    // DASHBOARD API
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboards/Dashboard');
    })->name('dashboard');

    Route::get('/admin', function () {
        $sql_1 = "
                select  *
                from    users
                where   fk_role = ?
        ";
        $sql_2 = "
                select  fk_chef, users.name, weekofyear(pizzas.ordered) as nr_week, count(*) as nr_pizzas
                from    pizzas inner join users on pizzas.fk_chef = users.id
                where   year(pizzas.ordered) = 2023 and fk_chef = ?
                group   by fk_chef, users.name, weekofyear(pizzas.ordered)
                order   by fk_chef, users.name, weekofyear(pizzas.ordered) DESC
        ";

        $chef_wd = [];
        foreach(DB::select($sql_1, [2]) as $chef){
            array_push($chef_wd, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff'
            ]);
        }

        $chef_md = [];
        $chef_md_stack = [];
        foreach(DB::select($sql_1, [2]) as $chef){
            array_push($chef_md, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff'
            ]);
            array_push($chef_md_stack, (object)[
                "label" => $chef->name,
                "data" => (new Collection(DB::select($sql_2, [$chef->id])))->map(fn($e):int => $e->nr_pizzas)->toArray(),
                "borderColor" => $chef->color,
                "backgroundColor" => $chef->color.'ff',
                "stack" => 'first'
            ]);
        }
        
        $sql_3 = "
                    select 
                            concat(users.id, ' - ', users.name, ' ( ', role.role_name, ' )') as title, 
                            holidays_start as start, 
                            holidays_end as end,
                            color,
                            'true' as allDay,
                            'true' as stick
                    from    users inner join role on users.fk_role = role.id
                    where   (fk_role = 3 or fk_role = 2) and holidays_start is not null and holidays_end is not null
            ";
        return Inertia::render('Dashboards/Admin',[
            "users" => User::all(),
            "chef_weekly_data" => $chef_wd,
            "chef_weekly_labels" => range(1, 53),
            "chef_monthly_data" => $chef_md,
            "chef_monthly_labels" => range(1, 12),
            "chef_monthly_data_stack" => $chef_md_stack,
            "chef_monthly_labels_stack" => range(1, 12),
            "holidays" => DB::select($sql_3)
        ]);
    })->name('admin');

    Route::get('/guest/{user}', function (User $user) {
        return Inertia::render('Dashboards/Guest', [
            "pizzas" => Pizza::all()->where("fk_client", $user->id)->flatten()->toArray(),
            "all_toppings" => Topping::all()->map(fn($e):string=>$e->name)->unique()->flatten()->toArray(),
            "new_pizza" => new Pizza()
        ]);
    })->name('guest');

    Route::get('/chef/{user}', function (User $user) {
        $sql =  "
                    select * 
                    from pizzas 
                    where (fk_pizzastatus is null or fk_chef is null or fk_chef = ?) and 
                           fk_pizzastatus <> 3
                    order by fk_chef ASC, fk_pizzastatus ASC
                ";
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => true,
            "pizzas" => DB::select($sql, [$user->id])
        ]);
    })->name('chef');

    Route::get('/deliveryman/{user}', function (User $user) {
        $sql = "
                    select * 
                    from pizzas 
                    where (fk_pizzastatus = 3 and fk_pizzastatus <> 6 and fk_deliveryman is null) or fk_deliveryman = ?
                    order by fk_deliveryman ASC
                ";
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => true,
            "pizzas" => DB::select($sql, [$user->id])
        ]);
    })->name('deliveryman');

    Route::get('/editrole/{user}', function (User $user) {
        return Inertia::render('Profile/Partials/EditRole', [
            "edituser" => User::all()->where('id',$user->id)->first(),
            "options" => Role::all()->map(fn($el):string=>$el->role_name)
        ]);
    })->name('editrole');

    Route::get('/editchef/{pizza}', function (Pizza $pizza) {
        return Inertia::render('Pizzas/EditPizzaStatus', [
            "pizza" => $pizza,
            "isChef" => true
        ]);
    })->name('editchef');

    Route::get('/editdeliveryman/{pizza}', function (Pizza $pizza) {
        $deliverystatus = $pizza->fk_deliverystatus;
        $next_status = null;
        
        if($deliverystatus == null) $next_status = Status::getStatusByName('Picked');
        else {
            $deliverystatus++;
            $next_status = Status::getStatusById($deliverystatus);
        }

        return Inertia::render('Pizzas/EditPizzaStatus', [
            "pizza" => $pizza,
            "next_text" => $next_status->name,
            "next_id" => $next_status->id,
            "isChef" => false
        ]);
    })->name('editdeliveryman');

    Route::get('/pizza-detail/{pizza}', [PizzaController::class, 'detail'])->name('pizzas.showorderdetail');

    Route::patch('/editrole/{user}', [ProfileController::class, 'update_role'])->name('user_role.update');
    Route::patch('/guest/{user}', [PizzaController::class, 'insert'])->name('pizza.insert');
    
    // PROFILE API
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';