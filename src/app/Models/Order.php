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

    public function rules($shipping_options)
	{

        foreach($shipping_options as $option) {
            $valid_shipping[] = $option['id'];
        }
        $valid_shipping = implode(",", $valid_shipping);

        foreach(config('shop.countries') as $country) {
            if ($country['allow_billing']) {
                $countries_billing[] = $country['code'];
            }
            if ($country['allow_shipping']) {
                $countries_shipping[] = $country['code'];
            }
        }
        $countries_billing = implode(",", $countries_billing);
        $countries_shipping = implode(",", $countries_shipping);

	    return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'billingPhone' => 'required|string',
            'billingAddress1' => 'required|string',
            'billingAddress2' => 'string',
            'billingCity' => 'required|string',
            'billingPostcode' => 'required|string',
            'billingState' => 'required|string',
            'billingCountry' => 'required|string|in:' . $countries_billing,
            'shippingAddress1' => 'required|string',
            'shippingAddress2' => 'string',
            'shippingCity'  => 'required|string',
            'shippingPostcode' => 'required|string',
            'shippingState' => 'required|string',
            'shippingCountry' => 'required|string|in:' . $countries_shipping,
            'instructions' => 'string',
            'shipping_type' => 'required|in:' . $valid_shipping
	    ];
	}

    public function messages()
    {
        return [
            'shippingCountry.in' => 'We do not currently support shipping to this country.',
            'billingCountry.in' => 'We do not currently support payments from this country.'
        ];
    }




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





}
