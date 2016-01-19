<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Product;

class ProductRepository
{

    /**
     * @param null|int
     * @return mixed
     */
    public function getAll($limit = null)
    {

        $products = $this->queryVisible(['images', 'categories'], null, $limit)->get();

        $products->each( function($m) {
            $m->image_types = $this->groupImagesByType($m);
        });

        return $products;

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $item = $this->queryVisible(['images', 'related', 'optionGroups', 'personalizations'], ['slug' => $slug])->firstOrFail();

        // Check if a project was found
        if ($item != null) {

            $item->image_types = $this->groupImagesByType($item);
            return $item;

        } else {
            // None found, throw a 404.
            abort('404', 'Invalid slug');
        }

    }

    /**
     * @param null $limit
     * @return mixed
     */
    public function getFeatured($limit = null)
    {

        $products = $this->queryVisible(['images'], ['featured' => '1'], $limit)->get();

        $products->each( function($m) {
            $m->image_types = $this->groupImagesByType($m);
        });

        return $products;

    }

    /**
     * @param $id
     * @param $route
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirectId($id, $route)
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
    private function queryVisible($with = [], array $where = null, $limit = null)
    {

        $query = Product::where('published', '!=', '0');

        if ($where) {
            $query->where($where);
        }

        $query->with(['images', 'categories'])
            ->limit($limit);

        return $query;

    }

    /**
     * @param $product
     * @return mixed
     */
    private function groupImagesByType($product)
    {
        return $product->images->groupBy('pivot.image_type');
    }

}