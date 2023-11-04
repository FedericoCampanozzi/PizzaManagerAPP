<?php

use App\Models\Status;
use App\Models\User;
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
        Schema::create('pizzas', function (Blueprint $table) {
            $table->id();
            $table->string('size');
            $table->string('crust');
            $table->timestamps();
            // constraint --> user.role = 'chef'
            $table->foreignIdFor(User::class, 'chef_id')->nullable();
            // constraint --> status.isPizzaStatus = 1
            $table->foreignIdFor(Status::class, 'pizza_idstatus')->nullable();
            // constraint --> user.role = 'deliveryman'
            $table->foreignIdFor(User::class, 'deliveryman_id')->nullable();
            // constraint --> status.isPizzaStatus = 0
            $table->foreignIdFor(Status::class, 'delivery_idstatus')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizzas');
    }
};
