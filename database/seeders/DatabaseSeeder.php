<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Pizza;
use App\Models\PizzaToppings;
use App\Models\Role;
use App\Models\Status;
use App\Models\User;
use App\Models\Topping;
use App\Utils\UtilityFunctions;
use Database\Factories\PizzaFactory;
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
        $pizzas = 100;
        if(env('APP_ENV') == "local")
            $pizzas = 1000;
        elseif(env('APP_ENV') == "prod") 
            $pizzas = 10;

        $toppingsForPizzaFactor = 3;
        $n_toppings = 15;

        ToppingFactory::pre_init($n_toppings);
        
        /* fixed role */
        UtilityFunctions::insert_static_data(Role::class, ['role_name'=>'admin']);
        UtilityFunctions::insert_static_data(Role::class, ['role_name'=>'chef']);
        UtilityFunctions::insert_static_data(Role::class, ['role_name'=>'delivery-man']);
        UtilityFunctions::insert_static_data(Role::class, ['role_name'=>'guest']);
        
        /* fixed status */
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Baking', 'isPizzaStatus'=>true, 'sequence'=>1]);
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Assembly', 'isPizzaStatus'=>true, 'sequence'=>2]);
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Ready', 'isPizzaStatus'=>true, 'sequence'=>3]);
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Picked', 'isPizzaStatus'=>false, 'sequence'=>1]);
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Arriving', 'isPizzaStatus'=>false, 'sequence'=>2]);
        UtilityFunctions::insert_static_data(Status::class, ['name'=>'Paid', 'isPizzaStatus'=>false, 'sequence'=>3]);
        
        /* test user */
        $psw = '$2y$10$mrMAK6zW7ozibP4Bj.Twlukw22/ARFSC88PRr0KUlE9zL.b1MFmVq'; // $psw = '123456789'
        $token = 'dz8SPElRRutjGXr70M8CwW71cbhjAFGEbsAWdNuxl4GRj75JzFcZgfup1eq1';
        UtilityFunctions::insert_static_data(User::class, ['name'=>'test.admin', 'email'=>'test.admin@c.com', 'fk_role'=>1, 'password'=>$psw, 'remember_token'=>$token, 'color'=>fake()->hexColor()]);
        UtilityFunctions::insert_static_data(User::class, ['name'=>'test.chef', 'email'=>'test.chef@c.com', 'fk_role'=>2, 'password'=>$psw, 'remember_token'=>$token, 'color'=>fake()->hexColor()]);
        UtilityFunctions::insert_static_data(User::class, ['name'=>'test.deliveryman', 'email'=>'test.deliveryman@c.com', 'fk_role'=>3, 'password'=>$psw, 'remember_token'=>$token, 'color'=>fake()->hexColor()]);
        UtilityFunctions::insert_static_data(User::class, ['name'=>'test.guest', 'email'=>'test.guest@c.com', 'fk_role'=>4, 'password'=>$psw, 'remember_token'=>$token, 'color'=>fake()->hexColor()]);
        
        User::factory(21)->create();

        PizzaFactory::pre_init_data();
        Topping::factory($n_toppings)->create();
        Pizza::factory($pizzas)->create();
        
        PizzaToppingsFactory::pre_init_indexes($pizzas * $toppingsForPizzaFactor);
        PizzaToppings::factory($pizzas * $toppingsForPizzaFactor)->create();
        
        /* test user to test changing role 
           this user don't have any foreing key because it's add after generation
        */
        UtilityFunctions::insert_static_data(User::class, ['name'=>'test.changerole', 'email'=>'test.changerole@c.com', 'fk_role'=>2, 'password'=>$psw, 'remember_token'=>$token, 'color'=>fake()->hexColor()]);
    }
}
