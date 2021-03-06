<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

	protected $table = 'products';

	protected $morphClass = 'DanPowell\Shop\Models\Product';

    protected $fillable = [
	    'title',
	    'description',
	    'slug',
	    'price',
	    'price_offer',
	    'weight',
	    'width',
	    'height',
	    'length',
	    'quantity',
	    'featured',
	    'published',
	    'meta_title',
	    'meta_description',
		'rank',
        'stock'
    ];

	public function rules($id = null)
	{
	    return [
	        'title' => 'required',
	        'slug' => 'required|unique:products,slug,' . $id,
			'price' => 'required|numeric',
			'price_offer' => 'numeric',
			'width' => 'numeric',
			'height' => 'numeric',
			'length' => 'numeric',
			'quantity' => 'integer',
	        'featured' => 'integer',
			'published' => 'integer',
            'stock' => 'integer',
			'rank' => 'integer',
	    ];
	}


    protected $casts = [
        'id' => 'integer',
		'price' => 'decimal',
		'price_offer' => 'decimal',
		'width' => 'float',
		'height' => 'float',
		'length' => 'float',
		'quantity' => 'integer',
		'featured' => 'integer',
		'published' => 'integer',
        'stock' => 'integer',
		'rank' => 'integer',
    ];

	//

    protected $appends = ['created_at_string', 'updated_at_string'];



	/* States */

	public function getIsOnOfferAttribute()
	{
		if($this->price_offer != null && $this->price_offer > 0) {
			return true;
		} else {
			return false;
		}
	}

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

	public function getHasSpecificationsAttribute()
	{
		if (
			($this->width != '' && $this->width > 0) ||
			($this->height != '' && $this->height > 0) ||
			($this->length != '' && $this->length > 0) ||
			($this->weight != '' && $this->weight > 0)
		) {
			return true;
		} else {
			return false;
		}
	}

	/* Attributes */

	public function getPriceOfferDifferenceAttribute()
	{
		return $this->price - $this->price_offer;
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

	/* Strings */

	public function getUpdatedAtStringAttribute()
	{
		return $this->updated_at->toFormattedDateString();
	}

	public function getCreatedAtStringAttribute()
	{
		return $this->created_at->toFormattedDateString();
	}

	public function getPriceStringAttribute()
	{
		return config('shop.currency.symbol') . $this->price;
	}

	public function getPriceOfferDifferenceStringAttribute()
	{
		return config('shop.currency.symbol') . ($this->price - $this->price_offer);
	}

	public function getPriceOfferStringAttribute()
	{
		return config('shop.currency.symbol') . $this->price_offer;
	}

	public function getWidthStringAttribute()
	{
		return $this->width . config('shop.units.width');
	}

	public function getHeightStringAttribute()
	{
		return $this->height . config('shop.units.height');
	}

	public function getLengthStringAttribute()
	{
		return $this->length . config('shop.units.length');
	}

	public function getWeightStringAttribute()
	{
		return $this->weight . config('shop.units.weight');
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

	// Scopes

	public function scopePublished($query)
	{
		return $query->where('published', '>', 0);
	}

	public function scopeFeatured($query)
	{
		return $query->where('featured', '=', 1);
	}


	// Relationships

	public function extras()
	{
		return $this->hasMany('DanPowell\Shop\Models\Extra', 'product_id');
	}

	public function options()
	{
		return $this->morphMany('DanPowell\Shop\Models\Option', 'option', 'attachment_type', 'attachment_id');
	}

	public function images()
	{
		return $this->morphToMany('DanPowell\Shop\Models\Image', 'images_attachments')->withPivot('image_type');
	}

	public function cartItems()
	{
		return $this->hasMany('DanPowell\Shop\Models\cartItem', 'product_id');
	}

	// Inverse Relationships

	public function categories()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\Category', 'product_categories', 'product_id', 'category_id');
	}

	public function related()
	{
		return $this->belongsToMany('DanPowell\Shop\Models\Product', 'product_related', 'product_id', 'related_id');
	}

	protected static function boot() {
		parent::boot();

		// When deleting we should also clean up any relationships
		static::deleting(function($model) {
			$model->images()->detach();
		});

		static::updated(function($model){
//			if ($model->isDirty('title') || $model->isDirty('price') || $model->isDirty('product_id')) {
//				$option->cartItems->each(function ($cartItem) {
//					$cartItem->invalidate();
//				});
//			}
		});

	}

}
