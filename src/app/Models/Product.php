<?php namespace DanPowell\Shop\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {

    protected $fillable = [
        'title',
        'slug',
        'seo_title',
        'seo_description',
        'markup',
        'styles',
        'scripts',
        'url',
        'featured',
        'template'
    ];

	public function rules($id = null)
	{
	    return [
	        'title' => 'required',
	        'slug' => 'required|unique:projects,slug,' . $id,
	        'featured' => 'integer',
	        'url' => 'url'
	    ];
	}


    protected $casts = [
        'id' => 'integer',
        'featured' => 'integer',
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



	public function tags()
    {
        return $this->morphToMany('DanPowell\Shop\Models\Tag', 'taggable');
    }

    public function sections()
    {
        return $this->morphMany('DanPowell\Shop\Models\Section', 'attachment')->orderBy('rank', 'ASC');
    }

    public function pages()
    {
        return $this->morphMany('DanPowell\Shop\Models\Page', 'attachment');
    }



    protected static function boot() {
        parent::boot();

        // When deleting a project we should also clean up any relationships
        static::deleting(function($project) {
             $project->sections()->delete();
             $project->pages()->delete();
             $project->tags()->detach();
        });
    }


}
