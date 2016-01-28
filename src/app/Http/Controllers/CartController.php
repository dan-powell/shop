<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;
use DanPowell\Shop\Models\CartOption;
use DanPowell\Shop\Models\CartPersonalisation;

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
            'total' => $this->getCartItemTotal($cart->cartItems),
            'itemsGrouped' => $this->groupCartItemsByProduct($cart->cartItems)
        ]);
    }

}
