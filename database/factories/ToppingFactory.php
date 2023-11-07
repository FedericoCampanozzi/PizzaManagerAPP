<?php

namespace Database\Factories;

use App\Utils\UtilityFunctions;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToppingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => UtilityFunctions::get_fake_food(),
            'price' => rand(20, 200)/100.0 // 0.20 -> 2.00
        ];
    }
}
