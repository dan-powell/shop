<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;

class CartRepository
{
    protected $model;
    protected $cart;

    public function __construct()
    {
        $this->model = new Cart();
    }

    /**
     * Get the Cart ID that is verified to exist for .
     * @return mixed
     */
    public function getCartId()
    {
        // Get the session ID from cookie
        $cart_id = request()->cookie('cart_id');

        $cart = Cart::where('id', '=', $cart_id)->first();

        // Create the cart
        if(!$cart) {
            $cart = Cart::create();
            cookie()->queue('cart_id', $cart->id, 10080);
        }

        // Return the ID
        return $cart->id;
    }

    /**
     * Get the Cart ID based on what is stored in the user's cookies.
     * NOTE: This method is insecure and should not be used when the cart ID needs to be trusted. Use 'getCartId' instead. This method is only used to save a database hit.
     * @return array|mixed|string
     */
    public function getCartIdInsecure()
    {
        // Get the session ID from cookie
        $cart_id = request()->cookie('cart_id');

        // if no cookie has been found, then create cart
        if(!$cart_id) {

            // Save to DB
            $cart = Cart::create();

            // Set the cookie
            cookie()->queue('cart_id', $cart->id, 10080);

            // Return the ID
            $cart_id = $cart->id;

        }

        // Return the ID
        return $cart_id;
    }

    /**
     * Return the Cart instance
     * @param array $with
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function getCart($with = [])
    {
        if (!$this->cart) {
            $this->cart = $this->model->with($with)->find($this->getCartIdInsecure());
        }

        return $this->cart;

    }

}