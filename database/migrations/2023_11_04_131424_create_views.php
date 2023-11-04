<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            create view toppingCountInPizzas as
            select pizzas.id, pizzas.crust, pizzas.size, u_chef.name as Chef, u_deliveryman.name as DeliveryMan, 
            SUM(
                case 
                    when pizzatoppings.topping_id is null then 0 
                    else 1 
                end
            ) as Toppings
            from pizzas inner join users u_chef on pizzas.chef_id = u_chef.id
            inner join users u_deliveryman on pizzas.deliveryman_id = u_deliveryman.id
            left join pizzatoppings on pizzas.id = pizzatoppings.pizza_id
            group by pizzas.id, pizzas.crust, pizzas.size, u_chef.name, u_deliveryman.name
        ");

        DB::statement("
            create view toppingInPizzas as
            select pizzas.id, pizzas.crust, pizzas.size, u_chef.name as Chef, u_deliveryman.name as DeliveryMan, topping.name
            from pizzas inner join users u_chef on pizzas.chef_id = u_chef.id
            inner join users u_deliveryman on pizzas.deliveryman_id = u_deliveryman.id
            left join pizzatoppings on pizzas.id = pizzatoppings.pizza_id
            left join topping on pizzatoppings.topping_id = topping.id
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW toppingCountInPizzas");
        DB::statement("DROP VIEW toppingInPizzas");
    }
};
