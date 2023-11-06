<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PizzaController extends Controller
{
    public function index(User $user): Response
    {
        return Inertia::render('Pizzas/All', [
            'pizzas' => Pizza::all()->where('fk_client', $user->id)
        ]);
    }

    public function edit(Pizza $pizza): Response
    {
        $pizzastatues = Status::all()
                            ->where('isPizzaStatus', true)
                            ->map(fn($el):string => $el->name)
                            ->values()
                            ->toArray();
        $deliverystatues = Status::all()
                            ->where('isPizzaStatus', false)
                            ->map(fn($el):string => $el->name)
                            ->values()                            
                            ->toArray();
        return Inertia::render('Pizzas/Edit', [
            'pizza' => $pizza,
            'pizzastatues' => $pizzastatues,
            'deliverystatues' => $deliverystatues,
            'toppings' => $pizza->getToppingsLinearAttribute()
        ]);
    }

    public function update(Pizza $pizza, Request $request): void
    {
        $pizza->update([
            'status' => $request->status
        ]);
    }
}
