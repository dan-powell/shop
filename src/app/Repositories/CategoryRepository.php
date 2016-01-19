<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Category;

class CategoryRepository
{

    /**
     * @param null|int
     * @return mixed
     */
    public function getAll($limit = null)
    {

        $categories = $this->queryVisible(['images'], null, $limit)->get();

        $categories->each( function($m) {
            $m->image_types = $this->groupImagesByType($m);
        });

        return $categories->toHierarchy();

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $item = $this->queryVisible(['images'], ['slug' => $slug])->first();

        // Check if item was found
        if ($item != null) {

            //TODO Need a cleaner way of retrieving only 'published' relationships
            $item->categories = $this->queryPublished($item->children())->get();
            $item->products = $this->queryPublished($item->products())->get();

            $item->products->each( function($m) {
                $m->image_types = $this->groupImagesByType($m);
            });

            $item->image_types = $this->groupImagesByType($item);
            return $item;

        } else {
            // None found, throw a 404.
            abort('404', 'Invalid slug');
        }

    }

    /**
     * @param $id
     * @param $route
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirectId($id, $route = 'shop.category.show')
    {

        // If a number is supplied, use that to find project by ID
        $item = $this->queryVisible()->find($id);

        // Check if a project was found
        if ($item) {
            // Project found OK, return a 301 redirect to the correct slug
            return redirect()->route($route, $item->slug, 301);
        } else {
            // No project found, throw a 404.
            abort('404', 'Matching id not found');
        }

    }

    /**
     * @param array $with
     * @param array|null $where
     * @param null $limit
     * @return mixed
     */
    public function queryVisible($with = [], array $where = null, $limit = null)
    {

        $query = Category::where('published', '!=', '0');

        if ($where) {
            $query->where($where);
        }

        $query->with($with)
            ->limit($limit);

        return $query;

    }


    public function queryPublished($query)
    {
        return $query->where('published', '!=', '0');
    }



    /**
     * @param $category
     * @return mixed
     */
    private function groupImagesByType($model)
    {
        return $model->images->groupBy('pivot.image_type');
    }

}