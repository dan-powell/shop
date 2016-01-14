<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Category extends Model {

    protected $fillable = [
        'title',
        'description',
        'slug',
        'meta_title',
        'meta_description',
    ];

    public function rules($id = null)
	{
	    return [
    	    'title' => 'required|unique:tags,title,' . $id,
    	    'slug' => 'unique:tags,slug,' . $id
	    ];
	}

    protected $casts = [
        'id' => 'integer'
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


	public function products()
    {
        return $this->morphedByMany('DanPowell\Shop\Models\Product', 'category');
    }

    protected $touches = ['projects'];


    protected static function boot() {
        parent::boot();

        // When deleting a tag we should also clean up any relationships
        static::deleting(function($tag) {
             $tag->projects()->detach();
        });

        // When saving, the slug is always a sluggified version of the title
        static::saving(function($tag) {
             $tag->slug = Str::slug($tag->title);
        });
    }

}
