<?php

use App\Http\Controllers\PizzaController;
use App\Http\Controllers\ProfileController;
use App\Models\Pizza;
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

    Route::get('/guest', function () {
        return Inertia::render('Dashboards/Guest');
    })->name('guest');

    Route::get('/chef/{user}', function (User $user) {
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => true,
            "pizzas" => Pizza::all()->where("fk_pizzastatus",null)->toArray()
        ]);
    })->name('chef');

    Route::get('/deliveryman/{user}', function (User $user) {
        return Inertia::render('Dashboards/Worker', [
            "isChefPage" => false,
            "pizzas" => []
        ]);
    })->name('deliveryman');

    Route::get('/editrole/{user}', function (User $user) {
        return Inertia::render('Profile/Partials/EditRole', [
            "edituser" => User::all()->where('id',$user->id)->first()
        ]);
    })->name('editrole');

    Route::get('/pizzas', [PizzaController::class, 'index'])->name('pizzas.index');
    Route::get('/pizzas/{pizza}', [PizzaController::class, 'edit'])->name('pizzas.edit');
    Route::patch('/pizzas/{pizza}', [PizzaController::class, 'update'])->name('pizzas.update');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
