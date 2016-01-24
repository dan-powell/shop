<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'price',
		'sub_total'
    ];

    public function rules()
	{
	    return [

	    ];
	}

    protected $casts = [
        'id' => 'integer',
    ];

    public $timestamps = false;


    // Relationships

	public function configs()
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
