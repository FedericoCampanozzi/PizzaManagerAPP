<?php

namespace Database\Factories;

use App\Utils\UtilityFunctions;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToppingFactory extends Factory
{
    private static $idx =-1;
    private static $names = [];
    
    public static function pre_init($item):void
    {
        for($i=0; $i < $item; $i++){
            do {
                $food = UtilityFunctions::get_fake_food();
            } while(array_search($food, self::$names) != null);
            array_push(self::$names, $food);
        }
    }

    public function definition(): array
    {
        self::$idx+=1;
        return [
            'name' => self::$names[self::$idx],
            'price' => rand(20, 200)/100.0 // 0.20 -> 2.00
        ];
    }
}
