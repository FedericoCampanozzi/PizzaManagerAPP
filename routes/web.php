<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PizzaController;
use App\Http\Controllers\PizzaToppingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPizzaController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Inertia\Inertia;

Route::get('/', function() {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::group(['middleware' => 'auth'], function () {

    /* GET API */
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::get('/admin', [DashboardController::class, 'admin'])->name('admin');
    Route::get('/guest/{user}', [DashboardController::class, 'guest'])->name('guest');
    Route::get('/chef/{user}', [DashboardController::class, 'chef'])->name('chef');
    Route::get('/deliveryman/{user}', [DashboardController::class, 'deliveryman'])->name('deliveryman');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/editrole/{user}', [RoleController::class, 'edit'])->name('role.edit');
    Route::get('/editchef/{pizza}', [PublicPizzaController::class, 'chef'])->name('edit.status.chef');
    Route::get('/editdeliveryman/{pizza}', [PublicPizzaController::class, 'deliveryman'])->name('edit.status.deliveryman');
    Route::get('/pizza-detail/{pizza}', [PizzaController::class, 'detail'])->name('pizzas.showorderdetail');

    /* PATCH API */
    Route::patch('/editrole/{user}/{role}', [ProfileController::class, 'update_role'])->name('profile.role.update');
    Route::patch('/guest/{crust}/{size}/{user}', [PizzaController::class, 'insert'])->name('pizza.insert');
    Route::patch('/guest/{topping}/{user}', [PizzaToppingController::class, 'insert'])->name('pizzatopping.insert');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/chef/{pizza}/{status}/{user}/{page}', [PizzaController::class, 'update'])->name('pizza.update');

    /* DELETE API */
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/pizza-detail/{pizza}/{user}', [PizzaController::class, 'destroy'])->name('pizza.destroy');
});

require __DIR__.'/auth.php';