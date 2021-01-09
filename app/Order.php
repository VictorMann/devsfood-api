<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total',
        'delivery',
        'discount',
        'address',
        'products'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function setAddressAttribute($value)
    {
        $this->attributes['address'] = json_encode($value);
    }

    public function setProductsAttribute($value)
    {
        $this->attributes['products'] = json_encode($value);
    }

    public function getAddressAttribute()
    {
        return json_decode($this->attributes['address']);
    }

    public function getProductsAttribute()
    {
        return json_decode($this->attributes['products']);
    }
}
