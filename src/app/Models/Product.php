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
		'rank'
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
			'rank' => 'integer',
	    ];
	}


    protected $casts = [
        'id' => 'integer',
		'price' => 'float',
		'price_offer' => 'float',
		'width' => 'float',
		'height' => 'float',
		'length' => 'float',
		'quantity' => 'integer',
		'featured' => 'integer',
		'published' => 'integer',
		'rank' => 'integer',
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

	// Relationships

	public function optionGroups()
	{
		return $this->hasMany('DanPowell\Shop\Models\OptionGroup', 'product_id')->with(['options']);
	}

	public function personalisations()
	{
		return $this->hasMany('DanPowell\Shop\Models\Personalisation', 'product_id');
	}

	public function images()
	{
		return $this->morphToMany('DanPowell\Shop\Models\Image', 'images_attachments')->withPivot('image_type');
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
	}

}
