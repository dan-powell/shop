<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartItem;

use Illuminate\Session;

class CartItemRepository extends AbstractRepository
{

    protected $model;
    protected $cart;

    public function __construct()
    {
        $this->model = new CartItem();
    }


    // Some methods to manage the cart instance

    /**
     * @return mixed
     */
    public function getCartId()
    {
        return $this->makeCart()->id;
    }

    /**
     * @return mixed
     */
    public function getCartItems()
    {
        return $this->makeCart(['cartItems'])->cartItems;
    }

    /**
     * @return Cart
     */
    public function getCart($with = [])
    {
        return $this->makeCart($with);
    }


    /**
     * @return Cart
     */
    public function clearCart()
    {
        return $this->makeQuery()->where('cart_id', '=', $this->getCartId())->delete();
    }

    /**
     * @return Cart
     */
    public function clearCartProduct($id)
    {
        return $this->makeQuery()->where('cart_id', '=', $this->getCartId())->where('product_id', '=', $id)->delete();
    }



    // Abstract class overrides

    /**
     * @param $id
     * @param array $with
     * @return mixed
     */
    public function getById($id, array $with = [])
    {
        return $this->makeQuery($with, ['id' => $id])->where('cart_id', '=', $this->getCartId())->first();
    }

    /**
     * @param $id
     * @param $quantity
     * @return mixed
     */
    public function update($id, $quantity) {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->update(['quantity' => $quantity]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id) {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->delete();
    }


    // Custom methods


    /**
     * @param array $fill
     * @param $quantity
     * @return mixed
     */
    public function incrementQuantity(array $fill, $quantity) {
        return $this->model->where($fill)->increment('quantity', $quantity);
    }


    // Private methods

    /**
     * @return Cart
     */
    private function makeCart($with = [])
    {
        

        if($this->cart == null) {

            // Get the session ID
            $cart_id = request()->cookie('cart_id');
            
            // Find the user's cart
            $this->cart = Cart::where('id', '=', $cart_id)->with($with)->first();

            // if no cart has been found, then create one
            if(!$this->cart) {
                $this->cart = new Cart();

                $this->cart->fill([
                    'session_id' => session()->getId()
                ]);

                $this->cart->save();
                
                
                cookie()->queue('cart_id', $this->cart->id, 10080);

                //return $response;
                
            }

        }

        return $this->cart;

    }

}