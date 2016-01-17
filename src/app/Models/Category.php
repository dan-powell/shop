<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Baum\Node;

class Category extends Node {

    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth', 'created_at', 'updated_at');

    public function rules($id = null)
	{
	    return [
    	    'title' => 'required|unique:tags,title,' . $id,
    	    'slug' => 'unique:tags,slug,' . $id,
            'rank' => 'integer',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
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

    public function categories()
    {
        return $this->hasMany('DanPowell\Shop\Models\Category');
    }

    public function products()
    {
        return $this->belongsToMany('DanPowell\Shop\Models\Product', 'product_categories', 'product_id', 'category_id');
    }

    public function images()
    {
        return $this->morphToMany('DanPowell\Shop\Models\Image', 'images_attachments');
    }

    // Inverse Relationships



    // Boot

    protected static function boot() {
        parent::boot();

        // When deleting we should also clean up any relationships
        static::deleting(function($model) {
            $model->images()->detach();
        });
    }

}
