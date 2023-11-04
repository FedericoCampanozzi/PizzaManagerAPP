<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PizzaToppings extends Model
{
    public $table = 'pizzatoppings';
    use HasFactory;

    protected $appends = [
        'pizza_id',
        'topping_id'
    ];
}
