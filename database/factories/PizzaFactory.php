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
        $chefs = User::getByRole(Role::getRoleByName('chef'));
        $pizzastatues = Status::getPizzaStatus();
        
        $deliverymans = User::getByRole(Role::getRoleByName('delivery-man'));
        $deliverystatues = Status::getDeliverymanStatus();

        return [
            'id' => rand(1111111, 9999999),
            'size' => Pizza::getSizes()[rand(0, 3)],
            'crust' => Pizza::getCrustSizes()[rand(0, 2)],
            'chef_id' => UtilityFunctions::pick_itm_random($chefs)["id"],
            'pizza_idstatus' => UtilityFunctions::pick_itm_random($pizzastatues)["id"],
            'deliveryman_id' => UtilityFunctions::pick_itm_random($deliverymans)["id"],
            'delivery_idstatus' => UtilityFunctions::pick_itm_random($deliverystatues)["id"],
        ];
    }
}
