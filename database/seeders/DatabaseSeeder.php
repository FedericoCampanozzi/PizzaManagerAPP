<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\Topping;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        Role::factory(4)->create();
        Status::factory(6)->create();
        Topping::factory(10)->create();
        User::factory(25)->create();
        Pizza::factory(20)->create();

        PizzaToppings::factory(25)->create();
    }
}
