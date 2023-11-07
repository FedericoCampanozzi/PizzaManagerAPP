<?php

use App\Models\Pizza;
use App\Models\Topping;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pizzatoppings', function (Blueprint $table) {
            $table->integer('fk_pizza')->unsigned()->foreign('fk_pizza')->references('id')->on('pizzas');
            $table->integer('fk_topping')->unsigned()->foreign('fk_topping')->references('id')->on('topping');
            $table->dateTime('inserted');
            $table->timestamps();
            $table->primary(['fk_pizza','fk_topping']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzatoppings');
    }
};
