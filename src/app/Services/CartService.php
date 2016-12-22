<?php

namespace DanPowell\Shop\Services;

use DanPowell\Shop\Repositories\CartRepository;

class CartService
{

    public $cart;
    protected $cartRepository;


    public function __construct(CartRepository $CartRepository)
    {

        $this->cartRepository = $CartRepository;
        $this->cart = $this->cartRepository->getCart(['cartItems.product', 'cartItems.extras.options', 'cartItems.options']);
    }


    public function getId()
    {
        return $this->cart->id;
    }


    public function getQuantity()
    {
        return $this->cart->cartItems->sum('quantity');
    }


}