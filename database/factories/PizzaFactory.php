<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Utils\UtilityFunctions;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pizza>
 */
class PizzaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clients = User::getByRole(Role::getRoleByName('guest'));
        $chefs = User::getByRole(Role::getRoleByName('chef'));
        $pizzastatues = Status::getPizzaStatus();
        
        $deliverymans = User::getByRole(Role::getRoleByName('delivery-man'));
        $deliverystatues = Status::getDeliverymanStatus();

        $rndPizzaStatus = UtilityFunctions::pick_itm_random($pizzastatues)["id"];
        $rndChef = UtilityFunctions::pick_itm_random($chefs)["id"];
        $rndDeliveryStatus = UtilityFunctions::pick_itm_random($deliverystatues)["id"];
        $rndDeliveryman = UtilityFunctions::pick_itm_random($deliverymans)["id"];
        
        if (rand(1,6) == 1){
            $rndPizzaStatus = null;
            $rndChef = null;
        }
        if($rndPizzaStatus == null || $rndPizzaStatus != 3){
            $rndDeliveryStatus = null;
            $rndDeliveryman = null;
        }
        return [
            'size' => Pizza::getSizes()[rand(0, 3)],
            'crust' => Pizza::getCrustSizes()[rand(0, 2)],
            'fk_client' => UtilityFunctions::pick_itm_random($clients)["id"],
            'fk_chef' => $rndChef,
            'fk_pizzastatus' => $rndPizzaStatus,
            'fk_deliveryman' => $rndDeliveryman,
            'fk_deliverystatus' => $rndDeliveryStatus,
            'ordered' => fake()->dateTimeBetween('-1 years')
        ];
    }
}
