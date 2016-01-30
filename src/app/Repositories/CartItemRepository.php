<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\CartItem;

class CartItemRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new CartItem();
    }




}