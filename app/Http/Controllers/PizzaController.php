<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Status;
use App\Models\Topping;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PizzaController extends Controller
{
    public function index(): Response
    {
        $pizzas = Pizza::all();

        return Inertia::render('Pizzas/All', [
            'pizzas' => $pizzas,
        ]);
    }

    public function edit(Pizza $pizza): Response
    {
        $statues = [];
        $toppings = '';
        foreach (Status::getPizzaStatus() as $status) {
            array_push($statues, $status['name']);
        }
        foreach (
                    PizzaToppings::join("topping","pizzatoppings.fk_topping","=","topping.id")
                        ->where('fk_pizza', $pizza->id)
                        ->select("topping.name","fk_pizza")
                        ->get() as $topping
                ) {
            $toppings = $toppings . $topping['name'].' ';
        }
        if($toppings == '') $toppings = 'Margherita';
        return Inertia::render('Pizzas/Edit', [
            'pizza' => $pizza,
            'statusOptions'=> $statues,
            'toppings'=> $toppings
        ]);
    }

    public function update(Pizza $pizza, Request $request): void
    {
        $pizza->update([
            'status' => $request->status
        ]);
    }
}
