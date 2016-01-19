<?php namespace DanPowell\Shop\Repositories;

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


    // Get all project tags as string
    public function redirectId(Model $model, $id, $route)
    {
        // If a number is supplied, use that to find project by ID
        $item = $model::find($id);

        // Check if a project was found
        if ($item) {
            // Project found OK, return a 301 redirect to the correct slug
            return redirect()->route($route, $item->slug, 301);
        } else {
            // No project found, throw a 404.
            return abort('404', 'Matching id not found');
        }

    }

}