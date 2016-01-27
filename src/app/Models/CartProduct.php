<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'price',
    ];

    public function rules()
	{
	    return [

	    ];
	}

    protected $casts = [
        'id' => 'integer',
        'price' => 'decimal'
    ];

    public $timestamps = false;


    // Relationships

	public function cartProductConfigs()
	{
		return $this->hasMany('DanPowell\Shop\Models\CartProductConfig');
	}

    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product', 'product_id');
	}

	public function cart()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Cart');
	}

}
