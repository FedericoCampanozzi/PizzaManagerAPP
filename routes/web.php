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
        $status = null;
        $userid = $user->id;
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => true,
            "pizzas" => Pizza::all()->where(function ($query) use ($status,$userid) {
                return $query->where('fk_pizzastatus', '=', $status)
                      ->orWhere('fk_chef', '=', $userid);
            } )->toArray()
        ]);
    })->name('chef');

    Route::get('/deliveryman/{user}', function (User $user) {
        $status = null;
        $userid = $user->id;
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => false,
            "pizzas" => Pizza::all()->where(function ($query) use ($status,$userid) {
                return $query->where('fk_pizzastatus', '=', $status)
                      ->orWhere('fk_chef', '=', $userid);
            } )->toArray()
        ]);
    })->name('deliveryman');

    Route::get('/editrole/{user}', function (User $user) {
        return Inertia::render('Profile/Partials/EditRole', [
            "edituser" => User::all()->where('id',$user->id)->first(),
            "options" => Role::all()->map(fn($el):string=>$el->role_name)
        ]);
    })->name('editrole');

    Route::get('/editchef', function () {
        return Inertia::render('Pizzas/EditPizzaStatus', [
            "statues" => Status::getPizzaStatus()
        ]);
    })->name('editchef');

    Route::get('/editdeliveryman', function () {
        return Inertia::render('Pizzas/EditPizzaStatus', [
            "statues" => Status::getDeliverymanStatus()
        ]);
    })->name('editdeliveryman');

    //Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
    //Route::get('/guest', [PizzaController::class, 'index'])->name('pizzas.index');
    Route::get('/pizzas/{pizza}', [PizzaController::class, 'detail'])->name('pizzas.showorderdetail');
    //Route::patch('/pizzas/{pizza}', [PizzaController::class, 'update'])->name('pizzas.update');

    Route::patch('/editrole/{user}', [ProfileController::class, 'update_role'])->name('user_role.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';