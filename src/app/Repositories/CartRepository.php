<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;

class CartRepository extends AbstractRepository
{

    protected $model;

    public function __construct()
    {
        $this->model = new Cart();
    }



    public function getCart($with = [])
    {

        $session_id = \Session::getId();

        $cart = $this->model->where('session_id', '=', $session_id)->with($with)->first();

        // if no cart has been found, then create one
        if(!$cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }


    public function createCart()
    {

        // Update the item with request data
        $cart = $this->model;

        $cart->fill([
            'session_id' => \Session::getId()
        ]);

        $cart->save();

        return $cart;

    }


}