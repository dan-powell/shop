<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model {

	protected $table = 'extras';

	protected $morphClass = 'DanPowell\Shop\Models\Extra';

    protected $fillable = [
        'title',
		'price',
        'description'
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

	public function getHasStockAttribute()
	{
		$bool = false;
		if($option->stock) {
			$bool = true;
		}
		return $bool;
	}




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
