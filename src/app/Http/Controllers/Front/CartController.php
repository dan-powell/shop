<?php namespace DanPowell\Shop\Http\Controllers\Front;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\CartItemRepository;

use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\CartTrait;

class CartController extends BaseController
{

    use ImageTrait;
    use CartTrait;

    protected $repository;
    protected $cartItemRepository;

    public function __construct(CartRepository $CartRepository, CartItemRepository $CartItemRepository)
    {
        $this->repository = $CartRepository;
        $this->cartItemRepository = $CartItemRepository;
    }

    /**
     * Show the Cart page and items
     * @return $this
     */
    public function show()
    {
        // Get the cart & items
        $cart = $this->repository->getCart([
            'cartItems.options',
            'cartItems.extras.options',
            'cartItems.product.images'
        ]);

        // Group the items by product
        return view('shop::front.cart.show.cartShow')->with([
            'cart' => $cart,
            'itemsGrouped' => $this->groupCartItemsByProduct($cart->cartItems)
        ]);
    }


    /**
     * Clear all CartItems from the cart
     * @return $this
     */
    public function clear()
    {
        $this->cartItemRepository->clear();

        \Notification::info('Cart Cleared');

        return redirect()->route('shop.cart.show', 301);
    }


    /**
     * Clear all CartItems with given Product ID
     * @param $id - Product ID
     * @return $this
     */
    public function clearProduct($id)
    {
        $this->cartItemRepository->clearProduct($id);

        \Notification::info('Product has been removed from your cart');

        return redirect()->route('shop.cart.show', 301);
    }

}
