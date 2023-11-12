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
    private static $clients = [];
    private static $chefs = [];
    private static $pizzastatues = [];
    private static $deliverymans = [];
    private static $deliverystatues = [];

    public static function pre_init_data()
    {
        self::$clients = User::getByRole(Role::getRoleByName('guest'));
        self::$pizzastatues = Status::getPizzaStatus();        
        self::$deliverymans = User::getByRole(Role::getRoleByName('delivery-man'));
        self::$chefs = User::getByRole(Role::getRoleByName('chef'));
        self::$deliverystatues = Status::getDeliverymanStatus();
    }

    public function definition(): array
    {
        $rndPizzaStatus = UtilityFunctions::pick_itm_random(self::$pizzastatues)["id"];
        $rndChef = UtilityFunctions::pick_itm_random(self::$chefs)["id"];
        $rndDeliveryStatus = UtilityFunctions::pick_itm_random(self::$deliverystatues)["id"];
        $rndDeliveryman = UtilityFunctions::pick_itm_random(self::$deliverymans)["id"];
        
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
            'fk_client' => UtilityFunctions::pick_itm_random(self::$clients)["id"],
            'fk_chef' => $rndChef,
            'fk_pizzastatus' => $rndPizzaStatus,
            'fk_deliveryman' => $rndDeliveryman,
            'fk_deliverystatus' => $rndDeliveryStatus,
            'ordered' => fake()->dateTimeBetween('-1 years')
        ];
    }
}
