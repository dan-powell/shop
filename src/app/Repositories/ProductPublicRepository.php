<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\ProductPublic;

class ProductPublicRepository extends ProductRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new ProductPublic();
    }


    public function getFeatured($limit = null)
    {
        return $this->makeQuery(['images'], ['featured' => '1'], $limit)->get();;
    }


    public function makeModel()
    {
        return $this->model->where('published', '!=', '0');
    }

}