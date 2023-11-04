<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    public $table = 'topping';
    use HasFactory;
    protected $fillable = [
        'name',
        'price'
    ];
}
