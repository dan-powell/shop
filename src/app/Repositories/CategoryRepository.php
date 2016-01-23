<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Category;

class CategoryRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Category();
    }

}