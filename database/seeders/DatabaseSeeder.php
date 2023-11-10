<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\Topping;
use Database\Factories\PizzaToppingsFactory;
use Database\Factories\ToppingFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $pizzas = 1000;
        $toppingsForPizzaFactor = 3;
        $n_toppings = 15;

        ToppingFactory::pre_init($n_toppings);

        Role::factory(4)->create();
        Status::factory(6)->create();
        Topping::factory($n_toppings)->create();
        User::factory(25)->create();
        Pizza::factory($pizzas)->create();

        PizzaToppingsFactory::pre_init_indexes($pizzas * $toppingsForPizzaFactor);
        PizzaToppings::factory($pizzas * $toppingsForPizzaFactor)->create();
    }
}
