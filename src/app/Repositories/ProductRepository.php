<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Product;
use DanPowell\Shop\Traits\ImageTrait;

class ProductRepository extends AbstractRepository
{

    use ImageTrait;

    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }


    public function getProductBySlug($slug)
    {
        $product = $this->getBySlug($slug, ['images', 'related.images', 'options', 'extras.options']);

        if($product) {

            // Group images on product
            $this->addImageTypes($product);

            // Group images on related products
            $product->related->each(function ($m) {
                $this->addImageTypes($m);
            });

            return $product;

        } else {
            return false;
        }
    }

}