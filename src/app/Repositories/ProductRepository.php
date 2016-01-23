<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Product;

class ProductRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Product();
    }

}