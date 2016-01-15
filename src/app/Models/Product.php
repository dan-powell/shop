<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {

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
		return $this->hasMany('DanPowell\Shop\Models\OptionGroup');
	}

	// Inverse Relationships





/*
    protected static function boot() {
        parent::boot();

        // When deleting a project we should also clean up any relationships
        static::deleting(function($project) {
             $project->sections()->delete();
             $project->pages()->delete();
             $project->tags()->detach();
        });
    }
*/


}
