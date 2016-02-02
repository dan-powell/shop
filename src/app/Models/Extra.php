<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Extra extends Model {

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
		foreach($this->options as $option) {
			if($option->stock) {
				$bool = true;
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
