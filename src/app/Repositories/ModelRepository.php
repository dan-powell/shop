<?php namespace DanPowell\Shop\Repositories;

/*
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;
*/

use Illuminate\Database\Eloquent\Model;


/**
 * A handy repo for doing common RESTful based things like indexing, saving etc.
 */
class ModelRepository
{

    public function getBySlug(Model $model, $slug, $with = [])
    {
        $query = $model::with($with)->where('slug', '=', $slug);
        $item = $query->first();

        // Check if a project was found
        if ($item != null) {
            return $item;
        } else {
            // No project found, throw a 404.
            abort('404', 'Invalid project slug');
        }

    }


    // Get all Things
    public function getAll(Model $model, $with = [], $order = 'created_at', $by = 'DESC')
    {
        return $model::with($with)->orderBy($order, $by)->get();
    }


    // Loop through all of the projects and concatenate the tags together as a single string - keeps the template clean
    public function addAllTagstoCollection($collection)
    {
        foreach ($collection as $item) {
            $item->allTags = $this->collateTagsAsString($item);
        }
        return $collection;
    }

    // Get all tags & filter so only those related to project are returned
    public function filterOnlyWithRelationship($collection, $related)
    {

        // Use Eloquent's filter method, returning only items that have a relationship with $related
        $collection = $collection->filter(function ($item) use ($related) {
            if (isset($item->$related) && count($item->$related) > 0) {
                return $item;
            }
        });

        return $collection;
    }

    // Get all project tags as string
    public function redirectId(Model $model, $id, $route)
    {
        // If a number is supplied, use that to find project by ID
        $item = $model::find($id);

        // Check if a project was found
        if ($item != null) {
            // Project found OK, return a 301 redirect to the correct slug
            return redirect()->route($route, $item->slug, 301);
        } else {
            // No project found, throw a 404.
            return abort('404', 'Matching id not found');
        }


    }

    // Get all project tags as string
    private function collateTagsAsString($item)
    {
        $tags = '';
        foreach ($item->tags as $tag) {
            $tags .= '-' . str_slug($tag->title) . ' ';
        }
        return $tags;
    }

}