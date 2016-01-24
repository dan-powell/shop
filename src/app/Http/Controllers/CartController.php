<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;
use DanPowell\Shop\Models\CartOption;
use DanPowell\Shop\Models\CartPersonalisation;

use DanPowell\Shop\Traits\ImageTrait;

class CartController extends BaseController
{

    use ImageTrait;

    protected $repository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->repository = $CartRepository;
    }


    public function index(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->repository->getCart([
            'cartProducts.product.images',
            'cartProducts.configs'
        ]);



        // Group product images
        $cart->cartProducts->each(function($cartProduct){
            $this->addImageTypes($cartProduct->product);
        });

        // Group products together by type
        // Ideally, it would be great if only items with options were displayed on thier own - identical products should be displayed with quantity

        $cart->groupedProducts = $cart->cartProducts->groupBy('product_id');


        return view('shop::cart.index')->with([
            'cart' => $cart
        ]);
    }







}
