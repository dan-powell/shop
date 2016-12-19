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
     * Get the Cart ID that is verified to exist.
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
            cookie()->queue('cart_id', $cart->id, config('shop.cartCookieTime'));
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
            cookie()->queue('cart_id', $cart->id, config('shop.cartCookieTime'));

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
            $this->cart = $this->model->with($with)->find($this->getCartId());
        }

        return $this->cart;

    }


    /**
     * Check that all CartItems are in stock and valid
     * @return array
     */
    public function validateCart($cart = null)
    {

        $check = true;
        $messages = [];

        if(!$cart) {
            $cart = $this->getCart(['cartItems.product']);
        }

        // Check we actually have items
        if(count($cart->cartItems) <= 0) {
            $check = false;
            \Notification::warning('There are no items in your cart.');
        }


        // Check the validity of all cart items
        $cart->cartItems->each(function($item){
            if (!$item->valid){
                $check = false;
                \Notification::warning('An item in your cart is invalid. Please either remove or replace it.');
            }

        });

        foreach($cart->cartItems->groupBy('product_id') as $itemGroup) {

            $cartQuantity = 0;

            foreach($itemGroup as $item) {
                $cartQuantity += $item->quantity;
            }

            $product = $itemGroup->first()->product;

            // Check product stock
            if (!$product->checkStock($cartQuantity)) {
                $check = false;
                \Notification::warning('We don\'t have enough of this product in stock.');
            }

            // Check product extras stock
//            foreach($product->extras as $extra) {
//                if (!$extra->checkStock($cartQuantity)) {
//                    $check = false;
//                    \Notification::warning('We don\'t have enough of this product extra in stock.');
//                }
//            };

        };

        return [
            'check' => $check,
            'messages' => $messages
        ];


        // Check that item products exist

        // Check that item options exist

        // Check that item extras exist


        // Check that item product has stock


        // Check that item extras have stock




    }

}