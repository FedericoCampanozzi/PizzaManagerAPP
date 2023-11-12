<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Status;
use App\Models\Topping;
use App\Models\User;
use DB;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
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

    public function update(Pizza $pizza, Status $status, User $user, string $page, Request $request)//: RedirectResponse
    {
        if ($page == "chef") {
            $pizza->fk_pizzastatus = $status->id;
            $pizza->fk_chef = $user->id;
            $pizza->update();
            return Redirect::route('chef', [$user]);
        }
        else {
            $pizza->fk_deliverystatus = $status->id;
            $pizza->fk_deliveryman = $user->id;
            $pizza->update();
            return Redirect::route('deliveryman', [$user]);
        }
    }

    public function insert(string $crust, string $size, User $user, Request $request): RedirectResponse
    {   
        $pizza = new Pizza();
        $pizza->size = $size;
        $pizza->crust = $crust;
        $pizza->fk_client = $user->id;
        $pizza->ordered = date('d-m-y h:i:s');
        $pizza->save();
        
        return Redirect::route('guest', [$user]);
    }

    public function destroy(Pizza $pizza, User $user, Request $request): RedirectResponse
    {
        $pizza->delete();
        return Redirect::route('guest', [$user]);
    }
}
