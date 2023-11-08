<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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

    public function detail(Pizza $pizza): Response
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
        return Inertia::render('Pizzas/ShowOrderDetail', [
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

    public function insert(Pizza $pizza, Request $request): RedirectResponse
    {
        $request->pizza->save();

        return Redirect::route('guest');
    }
}
