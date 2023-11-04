<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\Topping;
use App\Utils\UtilityFunctions;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PizzaToppings>
 */
class PizzaToppingsFactory extends Factory
{
    private static $ids = [];

    private static function chekIds($pizzaid, $toppingid){
        $f = array_search($pizzaid."".$toppingid, self::$ids);
        if(!$f) array_push(self::$ids,$pizzaid."".$toppingid);
        return $f;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $pizzas = Pizza::all()->toArray();
        $toppings = Topping::all()->toArray();
        $p_id = -1;
        $t_id = -1;
        
        do{
           $p_id = UtilityFunctions::pick_itm_random($pizzas)["id"];
           $t_id = UtilityFunctions::pick_itm_random($toppings)["id"];
        } while(PizzaToppingsFactory::chekIds($p_id, $t_id));

        return [
            'fk_pizza' => $p_id,
            'fk_topping' => $t_id,
        ];
    }
}
