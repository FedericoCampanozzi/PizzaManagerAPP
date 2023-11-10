<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Status;
use Inertia\Inertia;

class PublicPagesController extends Controller
{
    public function chef (Pizza $pizza) {
        return Inertia::render('Pizzas/EditPizzaStatus', [
            "pizza" => $pizza,
            "isChef" => true
        ]);
    }

    public function deliveryman (Pizza $pizza) {
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
    }

    private function public_worker(){
        
    }
}