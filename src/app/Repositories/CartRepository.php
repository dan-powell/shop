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

        // Get the session ID
        $session_id = \Session::getId();

        // Find the user's cart
        $cart = $this->model->where('session_id', '=', $session_id)->with($with)->first();

        // if no cart has been found, then create one
        if(!$cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }


    private function createCart()
    {

        $cart = $this->model;

        $cart->fill([
            'session_id' => \Session::getId()
        ]);

        $cart->save();

        return $cart;

    }


}