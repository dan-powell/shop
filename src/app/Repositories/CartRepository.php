<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;

class CartRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Cart();
    }

}