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
                    when pizzatoppings.fk_topping is null then 0 
                    else 1 
                end
            ) as Toppings
            from pizzas inner join users u_chef on pizzas.fk_chef = u_chef.id
            inner join users u_deliveryman on pizzas.fk_deliveryman = u_deliveryman.id
            left join pizzatoppings on pizzas.id = pizzatoppings.fk_pizza
            group by pizzas.id, pizzas.crust, pizzas.size, u_chef.name, u_deliveryman.name
        ");

        DB::statement("
            create view toppingInPizzas as
            
            select pizzas.id, pizzas.crust, pizzas.size, u_chef.name as Chef, u_deliveryman.name as DeliveryMan, topping.name
            from pizzas inner join users u_chef on pizzas.fk_chef = u_chef.id
            inner join users u_deliveryman on pizzas.fk_deliveryman = u_deliveryman.id
            left join pizzatoppings on pizzas.id = pizzatoppings.fk_pizza
            left join topping on pizzatoppings.fk_topping = topping.id
        ");

        DB::statement("
            create view pizzasInfoComplete as
            
            select  p.*,
                    uclient.name as client, 
                    uchef.name as chef,
                    pstatus.name as pizzastatus,
                    udeliveryman.name as deliveryman,
                    dstatus.name as deliverystatus
            from    pizzas as p inner join
                    users uclient on p.fk_client = uclient.id left join
                    users udeliveryman on p.fk_client = udeliveryman.id left join
                    users uchef on p.fk_client = uchef.id left join 
                    status pstatus on p.fk_pizzastatus = pstatus.id left join 
                    status dstatus on p.fk_deliverystatus = dstatus.id
    ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("DROP VIEW toppingCountInPizzas");
        DB::statement("DROP VIEW toppingInPizzas");
        DB::statement("DROP VIEW pizzasInfoComplete");
    }
};
