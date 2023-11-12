<?php

namespace App\Http\Controllers;

use App\Models\PizzaToppings;
use App\Models\Topping;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PizzaToppingController extends Controller
{
    public function insert(Topping $topping, User $user, Request $request): RedirectResponse
    {
        $sql = "
            select *
            from pizzas 
            where fk_client = ?
            order by id desc 
            limit 1
        ";
        $pizza = DB::select($sql, [$user->id])[0];
        
        $pizzatoppings = new PizzaToppings();
        $pizzatoppings->fk_pizza = $pizza->id;
        $pizzatoppings->fk_topping = $topping->id;
        $pizzatoppings->inserted = date('d-m-y h:i:s');
        $pizzatoppings->save();

        return Redirect::route('guest', [$user]);
    }
}