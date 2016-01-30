<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;

use DanPowell\Shop\Models\CartItem;


use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\CartTrait;

class CartController extends BaseController
{

    use ImageTrait;
    use CartTrait;

    protected $repository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->repository = $CartRepository;
    }


    public function index(Request $request)
    {

        // Get the cart & items
        $cart = $this->repository->getCart([
            'cartItems.product.images'
        ]);

        // Decode serialised data
        $cart->cartItems->each(function($cartItem) {
            $cartItem->options = json_decode($cartItem->options, true);
            $cartItem->personalisations = json_decode($cartItem->personalisations, true);
        });

        // Group the items by product
        return view('shop::cart.index')->with([
            'items' => $cart->cartItems,
            'total' => $this->getCartTotal($cart->cartItems),
            'itemsGrouped' => $this->groupCartItemsByProduct($cart->cartItems)
        ]);
    }


    public function destroy($id, Request $request)
    {
        $cart = $this->repository->getCart(['cartItems.product']);

        CartItem::where('cart_id', '=', $cart->id)->delete();

        return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Cart Cleared']);
    }

    public function destroyProduct($id, Request $request)
    {
        $cart = $this->repository->getCart(['cartItems.product']);

        CartItem::where('cart_id', '=', $cart->id)->where('product_id', '=', $id)->delete();

        return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Product has been removed from your cart']);
    }

}
