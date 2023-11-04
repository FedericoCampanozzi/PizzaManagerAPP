<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Symfony\Component\Console\Logger\ConsoleLogger;

class RoleFactory extends Factory
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
        $i = RoleFactory::getIdx();
        return [
            'role_name' => ["admin","chef","delivery-man","guest"][$i],
        ];
    }
}
