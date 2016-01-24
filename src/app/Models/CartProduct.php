<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model {

    protected $fillable = [
		'product_id',
		'cart_id',
		'options',
		'personalisations'
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
