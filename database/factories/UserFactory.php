<?php

namespace Database\Factories;

use App\Models\Role;
use App\Utils\UtilityFunctions;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $roles = Role::all()->toArray();
        $holidays_start = null;
        $holidays_end = null;
        if(rand(1, 3) == 1) {
            $h = fake()->dateTimeBetween('-1 years', '4 month');
            $day_add = rand(2, 7);
            $holidays_start = Carbon::parse($h)->addDays(-$day_add);
            $holidays_end = Carbon::parse($h)->addDays($day_add);
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '123456789',
            'remember_token' => Str::random(10),
            'fk_role' => UtilityFunctions::pick_itm_random($roles)["id"],
            'holidays_start' => $holidays_start,
            'holidays_end' => $holidays_end
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
