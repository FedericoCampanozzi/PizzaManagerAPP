<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = 'status';
    use HasFactory;
    protected $fillable = [
        'name',
        'isPizzaStatus',
        'sequence',
    ];

    public static function getPizzaStatus():array
    {
        return Status::all()->where('isPizzaStatus', true)->toArray();
    }

    public static function getDeliverymanStatus():array
    {
        return Status::all()->where('isPizzaStatus', false)->toArray();
    }
}
