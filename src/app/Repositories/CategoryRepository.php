<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Category;
use DanPowell\Shop\Models\CategoryPublished;
use DanPowell\Shop\Repositories\ImageRepository;

class CategoryRepository
{
    
    private $imageRepository;

    public function __construct(ImageRepository $imageRepository)
    {
        $this->imageRepository = $imageRepository;
    }
    

    /**
     * @param null|int
     * @return mixed
     */
    public function getAll($limit = null)
    {

        $categories = $this->queryVisible(['images'], null, $limit)->get();

        $categories->each( function($m) {
            $m->image_types = $this->imageRepository->groupImagesByType($m);
        });

        return $categories->toHierarchy();

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $item = $this->queryVisible(['images', 'products.images', 'children'], ['slug' => $slug])->first();

        // Check if item was found
        if ($item != null) {

            //TODO Need a cleaner way of retrieving only 'published' relationships
            //$item->children = $this->queryPublished($item->children())->get();
            //$item->products = $this->queryPublished($item->products())->get();

            $item->products->each( function($m) {
                $m->image_types = $this->imageRepository->groupImagesByType($m);
            });

            $item->image_types = $this->imageRepository->groupImagesByType($item);
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

        $query = CategoryPublished::where('published', '!=', '0');

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


}