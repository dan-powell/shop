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
            //'cartProducts.product.images',
            //'cartProducts.cartProductConfigs',
            'cartItems.product.images'
        ]);





        $test = $cart->cartItems->groupBy('product.id');





        $test->each(function($m){

            $m->product = $m->first()->product;


        });











//        $cart->cartProducts->each(function($cartProduct){
//
//            $cartProduct->cartProductConfigs = $cartProduct->cartProductConfigs->filter(function($m){
//
//                if((isset($m->options) && count(json_decode($m->options, true))) || (isset($m->personalisations) && count(json_decode($m->personalisations, true)))) {
//                    return $m;
//                };
//
//            });
//
//
//        });
//
//        //dd($cart->cartProducts);
//
//
//        // Group product images
//        $cart->cartProducts->each(function($cartProduct){
//
//            $arr = [];
//            foreach($cartProduct->cartProductConfigs as $config) {
//                array_push($arr, $config->sub_total);
//            };
//
//            $cartProduct->sub = array_sum($arr);
//
//            $this->addImageTypes($cartProduct->product);
//        });
//


        return view('shop::cart.index')->with([
            'cart' => $cart,
            'total' => $this->total($cart->cartProducts),

            'test' => $test

        ]);
    }



    private function total($products) {

        $arr = [];
        foreach($products as $product) {
            array_push($arr, $product->sub);
        };

        return array_sum($arr);

    }



}
