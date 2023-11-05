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
    ];

    protected $appends = [
        'client',
        'toppings',
        'chef',
        'status',
        'deliveryman',
        'delivery'
    ];

    public function getClientAttribute(): string
    {
        return $this->belongsTo(User::class,'fk_client')->get(['name'])->map(fn($el):string=>$el->name)->first();
    }
    
    public function getToppingsAttribute(): string
    {
        $t = PizzaToppings::join("topping","pizzatoppings.fk_topping","=","topping.id")
                    ->where('fk_pizza', $this->id)
                    ->select("topping.name","fk_pizza")
                    ->get()
                    ->map(fn($el,$idx):string => $idx.')'.' '.$el->name.' ')
                    ->join('');
        if ($t == '') $t = "No Toppings :(";
        else $t = "Toppings : ".$t;
        return $t;
    }
    
    public function getToppingsLinearAttribute(): string
    {
        $t = PizzaToppings::join("topping","pizzatoppings.fk_topping","=","topping.id")
                    ->where('fk_pizza', $this->id)
                    ->select("topping.name","fk_pizza")
                    ->get()
                    ->map(fn($el):string => $el->name.' ')
                    ->join('');
        if ($t == '') $t = "Margherita";
        return $t;
    }

    public function getChefAttribute(): string
    {
        return $this->belongsTo(User::class,'fk_chef')->get(['name'])->map(fn($el):string=>$el->name)->first();
    }

    public function getStatusAttribute(): string
    {
        return $this->belongsTo(Status::class,'fk_pizzastatus')->get(['name'])->map(fn($el):string=>$el->name)->first();
    }
    
    public function getDeliverymanAttribute(): string
    {
        return $this->belongsTo(User::class,'fk_deliveryman')->get(['name'])->map(fn($el):string=>$el->name)->first();
    }

    public function getDeliveryAttribute(): string
    {
        return $this->belongsTo(Status::class,'fk_deliverystatus')->get(['name'])->map(fn($el):string=>$el->name)->first();
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
