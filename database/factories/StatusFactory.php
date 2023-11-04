<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StatusFactory extends Factory
{
    static int $idx = -1;
    public static function getIdx(): int
    {
        self::$idx++;
        return self::$idx;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $i = StatusFactory::getIdx();
        return [
            'name'=>['Ordered','Baking','Ready','Picked','Arriving','Paid'][$i],
            'isPizzaStatus'=>[true,true,true,false,false,false][$i],
            'sequence'=>[1,2,3,1,2,3][$i]
        ];
    }
}
