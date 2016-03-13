<?php namespace DanPowell\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartItemRepository;

use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\CartTrait;

class CartController extends BaseController
{

    use ImageTrait;
    use CartTrait;

    protected $repository;

    public function __construct(CartItemRepository $CartItemRepository)
    {
        $this->repository = $CartItemRepository;
    }


    public function show(Request $request)
    {

        // Get the cart & items
        $cartItems = $this->repository->getCartItems([
            'options',
            'extras.options',
            'product.images'
        ]);

        // Group the items by product
        return view('shop::front.cart.show.cartShow')->with([
            'items' => $cartItems,
            'total' => config('shop.currency.symbol') . number_format($this->getCartTotal($cartItems), 2),
            'itemsGrouped' => $this->groupCartItemsByProduct($cartItems)
        ]);
    }


    public function clear()
    {

        $this->repository->clearCart();

        return redirect()->route('shop.cart.show', 301)->withInput(['warning' => 'Cart Cleared']);
    }


    public function clearProduct($id)
    {
        $this->repository->clearCartProduct($id);

        return redirect()->route('shop.cart.show', 301)->withInput(['warning' => 'Product has been removed from your cart']);
    }

}
