<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartItem;
use DanPowell\Shop\Repositories\ProductPublicRepository;
use DanPowell\Shop\Http\Requests\ProcessCartItemRequest;

use Illuminate\Session;


class CartItemRepository extends AbstractRepository
{

    protected $model;
    protected $productPublicRepository;

    public function __construct(ProductPublicRepository $ProductPublicRepository)
    {
        $this->model = new CartItem();
        $this->productPublicRepository = $ProductPublicRepository;
    }


    // Some methods to manage the cart instance

    /**
     * @return mixed
     */
    public function getCartId()
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

    public function getVerifiedCartId()
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
     * @return mixed
     */
    public function getCartItems($with = [])
    {
        return $this->model->where('cart_id', '=', $this->getCartId())->with($with)->get();
    }

    /**
     * @return Cart
     */
    public function getCart($with = [])
    {
        return Cart::with($with)->find($this->getCartId());
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
    public function update($id, $quantity)
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->update(['quantity' => $quantity]);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        return $this->makeQuery([], ['id' => $id])->where('cart_id', '=', $this->getCartId())->delete();
    }


    // Custom methods




    public function getTotalProductQuantityInCart($product_id)
    {
        // Find all items of the same product, so we can calculate the total quantity in the cart
        $items = $this->getCartItems()->where(
            'product_id', $product_id
        )->all();

        // Get the total quantity of Product currently in the cart
        if($items) {
            $quantity = 0;

            // Sum all cart items linked to product
            foreach($items as $item) {
                $quantity += $item->quantity;
            }

            return $quantity;

        } else {
            return 0;
        }
    }






    /**
     * @param array $fill
     * @param $quantity
     * @return mixed
     */
    public function incrementQuantity(array $fill, $quantity)
    {
        return $this->model->where($fill)->increment('quantity', $quantity);
    }





}