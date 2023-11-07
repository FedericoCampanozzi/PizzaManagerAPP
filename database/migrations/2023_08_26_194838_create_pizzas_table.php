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
            $table->integer('id')->unsigned()->autoIncrement();
            $table->string('size');
            $table->string('crust');
            $table->dateTime('ordered');
            
            // constraint --> user.role = 'guest'
            $table->integer('fk_client')->unsigned()->foreign('fk_client')->references('id')->on('users');
            
            // constraint --> user.role = 'chef'
            $table->integer('fk_chef')->unsigned()->foreign('fk_chef')->references('id')->on('users')->nullable();
            
            // constraint --> status.isPizzaStatus = 1
            $table->integer('fk_pizzastatus')->unsigned()->foreign('fk_pizzastatus')->references('id')->on('status')->nullable();
            
            // constraint --> user.role = 'deliveryman'
            $table->integer('fk_deliveryman')->unsigned()->foreign('fk_deliveryman')->references('id')->on('users')->nullable();
            
            // constraint --> status.isPizzaStatus = 0
            $table->integer('fk_deliverystatus')->unsigned()->foreign('fk_deliverystatus')->references('id')->on('status')->nullable();
            
            $table->timestamps();
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
