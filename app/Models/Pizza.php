<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pizza extends Model
{
    use HasFactory;
    protected $appends = [
        'client_name'
    ];
    /*
    protected $guarded = [];
    
    protected $appends = [
        'chef_name',
        'pizza_status',
        'deliveryman_name',
        'delivery_status',
        'last_updated'
    ];
    protected $hidden = [];
    */
    public function getClientNameAttribute(): string
    {
        return $this->belongsTo(User::class,'chef_id')->name;
    }
    /*
    public function getChefNameAttribute(): string
    {
        return $this->hasOne(User::class,'chef_id')->name;
    }

    public function getPizzaStatusAttribute(): string
    {
        return $this->belongsTo(Status::class,'pizza_idstatus')->name;
    }
    
    public function getDeliverymanNameAttribute(): string
    {
        return $this->belongsTo(User::class,'deliveryman_id')->name;
    }

    public function getDeliveryStatusAttribute(): string
    {
        return $this->belongsTo(Status::class,'delivery_idstatus')->name;
    }

    public function getLastUpdatedAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
    */
    public static function getSizes():array
    {
        return ['Small', 'Medium', 'Large', 'Extra-Large'];
    }

    public static function getCrustSizes():array
    {
        return ['Regular', 'Thin', 'Garlic'];
    }
}
