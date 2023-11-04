<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pizza extends Model
{
    public $table = 'pizzas';

    use HasFactory;
    protected $fillable = [
        'client',
        'toppings'
    ];

    public function getClientAttribute(): BelongsTo
    {
        return $this->belongsTo(User::class,'fk_client');
    }
    
    public function getToppingsAttribute(): string
    {
        $str = '';
        foreach (PizzaToppings::all()->where('fk_pizza',$this->id) as $topping) {
            $str .= ''. $topping->name .' ';
        }
        return $str;
    }

    public function getChefAttribute(): BelongsTo
    {
        return $this->hasOne(User::class,'fk_chef')->name;
    }

    public function getPizzaStatusAttribute(): BelongsTo
    {
        return $this->belongsTo(Status::class,'fk_pizzastatus')->name;
    }
    
    public function getDeliverymanAttribute(): BelongsTo
    {
        return $this->belongsTo(User::class,'fk_deliveryman')->name;
    }

    public function getDeliveryStatusAttribute(): BelongsTo
    {
        return $this->belongsTo(Status::class,'fk_deliverystatus')->name;
    }

    public function getLastUpdatedAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
    
    public static function getSizes():array
    {
        return ['Small', 'Medium', 'Large', 'Extra-Large'];
    }

    public static function getCrustSizes():array
    {
        return ['Regular', 'Thin', 'Garlic'];
    }
}
