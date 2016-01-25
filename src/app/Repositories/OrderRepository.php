<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Order;

class OrderRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Order();
    }





}