<?php namespace DanPowell\Shop\Models;

use Illuminate\Support\Str;
use Baum\Node;

class Category extends Node {
    
    protected $table = 'categories';
    
    protected $morphClass = 'DanPowell\Shop\Models\Category';

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

    protected $appends = ['created_at_string', 'updated_at_string'];

    public function getUpdatedAtStringAttribute()
    {
        return $this->updated_at->toFormattedDateString();
    }

    public function getCreatedAtStringAttribute()
    {
        return $this->created_at->toFormattedDateString();
    }

    public function getPublishedAttribute()
    {
        if($this->published > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Scopes

    public function scopePublished($query)
    {
        return $query->where('published', '>', 0);
    }


    // Relationships

    public function categories()
    {
        return $this->hasMany('DanPowell\Shop\Models\Category');
    }

    public function products()
    {
        return $this->belongsToMany('DanPowell\Shop\Models\Product', 'product_categories', 'category_id', 'product_id');
    }

    public function images()
    {
        return $this->morphToMany('DanPowell\Shop\Models\Image', 'images_attachments')->withPivot('image_type');
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
