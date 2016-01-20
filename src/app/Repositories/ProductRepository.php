<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Product;
use DanPowell\Shop\Models\ProductPublic;
use DanPowell\Shop\Repositories\ImageRepository;

class ProductRepository
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

        $products = $this->queryVisible(['images', 'categories'], null, $limit)->get();

        $products->each( function($m) {
            $m->image_types = $this->imageRepository->groupImagesByType($m);
        });

        return $products;

    }

    /**
     * @param $slug
     * @return mixed
     */
    public function getBySlug($slug)
    {
        $item = $this->queryVisible(['images', 'related.images', 'optionGroups', 'personalizations'], ['slug' => $slug])->first();

        // Check if a project was found
        if ($item != null) {

            $item->image_types = $this->imageRepository->groupImagesByType($item);


            // Product images need to be grouped by type
            $item->related->each( function($m) {
                $m->image_types = $this->imageRepository->groupImagesByType($m);
            });


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
            $m->image_types = $this->imageRepository->groupImagesByType($m);
        });

        return $products;

    }

    /**
     * @param $id
     * @param $route
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirectId($id, $route = 'shop.product.show')
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

        $query = ProductPublic::where('published', '!=', '0');

        if ($where) {
            $query->where($where);
        }

        $query->with($with)
            ->limit($limit);

        return $query;

    }

}