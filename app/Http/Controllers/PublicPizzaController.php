<?php

namespace App\Http\Controllers;

use App\Models\Pizza;
use App\Models\Status;
use Inertia\Inertia;

class PublicPizzaController extends Controller
{
    public function chef (Pizza $pizza) {
        return $this->worker($pizza, 'Baking', true, 3);
    }

    public function deliveryman (Pizza $pizza) {
        return $this->worker($pizza, 'Picker', false, 6);
    }

    private function worker (Pizza $pizza, string $startstatus, bool $isChef, int $limit) {
        $id_status = $isChef ? $pizza->fk_pizzastatus : $pizza->fk_deliverystatus;
        $next_status = null;
        
        if($id_status == null) $next_status = Status::getStatusByName($startstatus);
        else if($id_status < $limit) {
            $id_status++;
            $next_status = Status::getStatusById($id_status);
        }

        return Inertia::render('Pizzas/EditPizzaStatus', [
            "pizza" => $pizza,
            "next_status" => $next_status,
            "isChef" => $isChef
        ]);
    }

    private function public_worker(){
        
    }
}