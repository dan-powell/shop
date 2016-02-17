<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model {

	protected $table = 'extras';

	protected $morphClass = 'DanPowell\Shop\Models\Extra';

    protected $fillable = [
        'title',
		'price',
        'description',
		'stock'
    ];

    public function rules()
	{
	    return [
    	    'title' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer'
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

	public function getHasOptionStockAttribute()
	{
		$bool = false;
		foreach($this->options as $option) {
			if($option->getIsInStockAttribute()){
				$bool = true;
			}
		}

		return $bool;
	}

	/* Attributes */

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

	/* Strings */

	public function getPriceStringAttribute()
	{
		return config('shop.currency.symbol') . $this->price;
	}

	/* Functions */

	public function checkStock($quantity) {
		$bool = true;
		if($quantity > $this->stock) {
			$bool = false;
		}
		return $bool;
	}



    // Relationships

	public function options()
	{
		return $this->morphMany('DanPowell\Shop\Models\Option', 'option', 'attachment_type', 'attachment_id');
	}

    // Inverse Relationships

	public function product()
	{
		return $this->belongsTo('DanPowell\Shop\Models\Product');
	}

	public function cartItems()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\CartItem', 'cart_item_extras', 'cart_item_id', 'extra_id');
	}



	protected static function boot()
	{
		parent::boot();

		// Events

		static::updated(function($model){
			// On update, invalidate any associated cart items
			if ($model->isDirty('title') || $model->isDirty('price') || $model->isDirty('product_id')) {
				$model->product->cartItems->each(function ($cartItem) {
					$cartItem->invalidate();
				});
			}
		});
	}


}
