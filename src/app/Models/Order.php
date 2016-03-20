<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model {

    protected $fillable = [
        'session_id',
        'cart',
        'status',
        'total',
        'firstName',
        'lastName',
        'email',
        'billingPhone',
        'billingAddress1',
        'billingAddress2',
        'billingCity',
        'billingPostcode',
        'billingState',
        'billingCountry',
        'shippingAddress1',
        'shippingAddress2',
        'shippingCity',
        'shippingPostcode',
        'shippingState',
        'shippingCountry',
        'notes',
        'instructions',
        'shipping_type'
    ];

    protected $casts = [
        'id' => 'integer'
    ];

    protected $appends = ['created_at_human', 'updated_at_human'];

    public function getUpdatedAtHumanAttribute()
    {
        return $this->updated_at->toFormattedDateString();
    }

    public function getCreatedAtHumanAttribute()
    {
        return $this->created_at->toFormattedDateString();
    }


    public function getConfigAttribute()
    {
        return json_decode($this->attributes['cart'], true);
    }

    public function setConfigAttribute($value)
    {
        $this->attributes['cart'] = json_encode($value);
    }



    public function getShippingTypeAttribute()
    {
        return json_decode($this->attributes['shipping_type'], true);
    }


    public function setShippingTypeAttribute($value)
    {
        $this->attributes['shipping_type'] = json_encode($value);
    }


    public function getPriceTotalStringAttribute()
    {
        return config('shop.currency.symbol') . number_format($this->total, 2);
    }



}
