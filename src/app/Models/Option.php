<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model {

    protected $fillable = [
		'title',
		'description',
		'type',
		'config',
		'stock'
    ];

	protected $hidden = ['attachment_id' ,'attachment_type'];

    public function rules()
	{
	    return [
    	    'title' => 'required',
			'type' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
		'config' => 'array'
    ];

    public $timestamps = false;


	/* States */

	public function getIsAvailableAttribute()
	{
		return $this->getIsInStockAttribute();
	}

	public function getIsInStockAttribute()
	{
		if($this->stock > 0) {
			return true;
		} else {
			return false;
		}
	}

	/* Attributes */

	public function getConfigAttribute()
	{
		return json_decode($this->attributes['config'], true);
	}

	public function setConfigAttribute($value)
	{
		$this->attributes['config'] = json_encode($value);
	}

	public function getStockStatusAttribute()
	{
		$key = null;
		foreach(config('shop.stock_status') as $status) {
			if ($this->stock < $status['max']) {
				$key = $status;
			}
		}
		return $key;
	}

	/* Functions */

	public function checkStock($quantity) {
		$bool = true;
		if(!$this->allow_negative_stock) {
			if($quantity > $this->stock) {
				$bool = false;
			}
		}
		return $bool;
	}


    // Relationships



    // Inverse Relationships

	public function attachment()
	{
		return $this->morphTo();
	}

	public function cartItems()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\CartItem', 'cart_item_options', 'cart_item_id', 'option_id');
	}



	protected static function boot()
	{
		parent::boot();

		// Events

		static::updated(function($option){

			// On update, invalidate any associated cart items
			if ($option->isDirty()) {
				if($option->attachment_type == 'DanPowell\Shop\Models\Product') {
					$option->attachment->cartItems->each(function ($cartItem) {
						$cartItem->invalidate();
					});
				} elseif($option->attachment_type == 'DanPowell\Shop\Models\Extra') {
					$option->attachment->product->cartItems->each(function ($cartItem) {
						$cartItem->invalidate();
					});
				}

			}
		});
	}

}
