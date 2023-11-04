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
            $table->foreignIdFor(Pizza::class, 'pizza_id');
            $table->foreignIdFor(Topping::class, 'topping_id');
            $table->primary(['pizza_id','topping_id']);
            $table->timestamps();
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
