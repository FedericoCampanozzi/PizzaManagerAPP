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
        'size',
        'crust',
        'fk_client',
        'fk_chef',
        'fk_pizzastatus',
        'fk_deliveryman',
        'fk_deliverystatus',
        'ordered'
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
        return $this->computeBelongsToName(User::class,'fk_client', '');
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
        return $this->computeBelongsToName(User::class,'fk_chef', '');
    }

    public function getStatusAttribute(): string
    {
        return $this->computeBelongsToName(Status::class,'fk_pizzastatus', '');
    }
    
    public function getDeliverymanAttribute(): string
    {
        return $this->computeBelongsToName(User::class,'fk_deliveryman', '');
    }

    public function getDeliveryAttribute(): string
    {
        return $this->computeBelongsToName(Status::class,'fk_deliverystatus', '');
    }
    
    public static function getSizes():array
    {
        return ['Small', 'Medium', 'Large', 'Extra-Large'];
    }

    public static function getCrustSizes():array
    {
        return ['Regular', 'Thin', 'Garlic'];
    }

    private function computeBelongsToName(string $class, string $clm, string $defaultValue):string
    {
        $value = $this->belongsTo($class,$clm)->get(['name'])->map(fn($el):string=>$el->name);
        if(count($value) == 0) return $defaultValue;
        else return $value->first();
    }
}
