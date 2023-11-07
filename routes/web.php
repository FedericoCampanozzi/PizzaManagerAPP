<?php

use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProfileController;
use App\Models\Pizza;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
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
        return Inertia::render('Dashboards/Admin',[
            "users" => User::all()
        ]);
    })->name('admin');

    Route::get('/guest/{user}', function (User $user) {
        return Inertia::render('Dashboards/Guest', [
            "pizzas" => Pizza::all()->where("fk_client", $user->id)->flatten()->toArray()
        ]);
    })->name('guest');

    Route::get('/chef/{user}', function (User $user) {
        $sql =  "
                    select * 
                    from pizzas 
                    where fk_pizzastatus is null or fk_chef is null or fk_chef = ?
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
                    where (fk_pizzastatus = 3 and fk_deliveryman is null) or fk_deliveryman = ?
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
            "statues" => Status::all()->where('isPizzaStatus', true)->map(fn($el):string => $el->name)->flatten()->toArray(),
            "pizza" => $pizza,
            "isChef" => true
        ]);
    })->name('editchef');

    Route::get('/editdeliveryman/{pizza}', function (Pizza $pizza) {
        return Inertia::render('Pizzas/EditPizzaStatus', [
            "statues" => Status::all()->where('isPizzaStatus', false)->map(fn($el):string => $el->name)->flatten()->toArray(),
            "pizza" => $pizza,
            "isChef" => false
        ]);
    })->name('editdeliveryman');

    Route::get('/pizza-detail/{pizza}', [PizzaController::class, 'detail'])->name('pizzas.showorderdetail');

    Route::patch('/editrole/{user}', [ProfileController::class, 'update_role'])->name('user_role.update');
    
    // PROFILE API
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';