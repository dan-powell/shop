<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model {

    protected $fillable = [
        'title',
        'description',
        'slug',
        'rank',
        'published',
        'meta_title',
        'meta_description'
    ];

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
        return $this->hasMany('DanPowell\Shop\Models\Product');
    }

    public function images()
    {
        return $this->morphToMany('DanPowell\Shop\Models\Image', 'images_attachments');
    }

    // Inverse Relationships

    public function parentCategory()
    {
        return $this->belongsTo('DanPowell\Shop\Models\Category');
    }


    protected static function boot() {
        parent::boot();

        // When deleting we should also clean up any relationships
        static::deleting(function($model) {
            $model->images()->detach();
        });
    }

}
