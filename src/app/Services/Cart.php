<?php

namespace DanPowell\Shop\Services;

use DanPowell\Shop\Repositories\CartRepository;

class Cart
{

    protected $cart;
    protected $cartRepository;


    public function __construct(CartRepository $CartRepository)
    {
        $this->cart = null;
        $this->cartRepository = $CartRepository;
    }


    public function getCart()
    {
        if ($this->cart ==  null) {
            $this->cart = $this->cartRepository->getCartId();
        }

        return $this->cart;
    }
}