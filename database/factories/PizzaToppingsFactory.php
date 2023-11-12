<?php

namespace Database\Factories;

use App\Models\Pizza;
use App\Models\Topping;
use App\Utils\UtilityFunctions;
use Illuminate\Database\Eloquent\Factories\Factory;

class PizzaToppingsFactory extends Factory
{
    private static $pindex = -1;
    private static $tindex = -1;
    private static $indexes = [];
    private static $indexes_pizza = [];
    private static $indexes_toppings = [];

    public static function pre_init_indexes($array_length): void
    {
        $pizzas = Pizza::all()->toArray();
        $toppings = Topping::all()->toArray();
        $p_id = -1;
        $t_id = -1;
        for($i=0; $i < $array_length; $i++) {
            do {
               $p_id = UtilityFunctions::pick_itm_random($pizzas)["id"];
               $t_id = UtilityFunctions::pick_itm_random($toppings)["id"];
            } while(PizzaToppingsFactory::chekIds($p_id, $t_id));
        }        
    }

    private static function chekIds($pizzaid, $toppingid) {
        $key = $pizzaid * 10000 + $toppingid;
        $find = array_search($key, self::$indexes);
        if(!$find) {
            array_push(self::$indexes, $key);
            array_push(self::$indexes_pizza, $pizzaid);
            array_push(self::$indexes_toppings, $toppingid);
        }
        return $find;
    }

    public function definition(): array
    {
        self::$pindex++;
        self::$tindex++;
        return [
            'fk_pizza' => self::$indexes_pizza[self::$pindex],
            'fk_topping' => self::$indexes_toppings[self::$tindex],
            'inserted' => fake()->dateTimeBetween('-1 years')
        ];
    }
}
