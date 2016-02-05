<?php namespace DanPowell\Shop\Http\Controllers;


use Illuminate\Routing\Controller;

class BaseController extends Controller
{

    public function __construct()
    {

    }


    protected function findItemOrFail($slug, array $with = [])
    {

        $item = $this->repository->getBySlug($slug, $with);

        // Check if a project was found
        if ($item) {
            return $item;

        } else {
            // None found, throw a 404.
            abort('404', 'Invalid slug');
        }

    }

    protected function redirectById($id, $route)
    {

        $item = $this->repository->getById($id);

        // Check if a project was found
        if ($item != null) {

            return redirect()->route($route, $item->slug, 301);

        } else {
            // None found, throw a 404.
            abort('404', 'Invalid slug');
        }


    }

}








