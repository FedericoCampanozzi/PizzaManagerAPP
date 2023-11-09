<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    public $table = 'status';
    use HasFactory;
    protected $fillable = [];

    public static function getPizzaStatus():array
    {
        return Status::all()->where('isPizzaStatus', true)->toArray();
    }

    public static function getDeliverymanStatus():array
    {
        return Status::all()->where('isPizzaStatus', false)->toArray();
    }

    public static function getStatusByName($statusname) : Status
    {
        return Status::all()->where('name', $statusname)->first();
    }

    public static function getStatusById($statusid) : Status
    {
        return Status::all()->where('id', $statusid)->first();
    }
}
