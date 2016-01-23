<?php namespace DanPowell\Shop\Traits;


trait ControllerTrait
{


    private function findItemOrFail($slug)
    {

        $item = $this->repository->getBySlug($slug);

        // Check if a project was found
        if ($item) {
            return $item;

        } else {
            // None found, throw a 404.
            abort('404', 'Invalid slug');
        }

    }

    private function redirectById($id, $route)
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