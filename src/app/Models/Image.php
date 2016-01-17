<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {

    protected $fillable = [
	    'title',
	    'filename',
	    'alt'
    ];

	public function rules($id = null)
	{
	    return [
	        'title' => 'required',
	    ];
	}

    protected $casts = [
        'id' => 'integer',
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

	public function attachment()
    {
        return $this->morphTo();
    }

    // Inverse Relationships

    public function products()
    {
        return $this->morphMany('DanPowell\Shop\Models\Product', 'attachment')->withPivot('image_type');
    }

    public function categories()
    {
        return $this->morphMany('DanPowell\Shop\Models\Category', 'attachment')->withPivot('image_type');
    }


    protected static function boot() {
        parent::boot();

        // When deleting we should also clean up any relationships
        static::deleting(function($model) {
            $model->products()->detach();
            $model->categories()->detach();
        });
    }


}
