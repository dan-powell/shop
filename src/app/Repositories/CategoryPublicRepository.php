<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\CategoryPublic;

class CategoryPublicRepository extends CategoryRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new CategoryPublic();
    }

    public function makeModel()
    {
        return $this->model->published();
    }

}