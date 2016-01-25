<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\OrderRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;
use DanPowell\Shop\Models\CartOption;
use DanPowell\Shop\Models\CartPersonalisation;
use DanPowell\Shop\Models\Order;

use DanPowell\Shop\Traits\ImageTrait;

class OrderController extends BaseController
{

    use ImageTrait;

    protected $repository;
    protected $cartRepository;

    public function __construct(OrderRepository $OrderRepository, CartRepository $CartRepository)
    {
        $this->repository = $OrderRepository;
        $this->cartRepository = $CartRepository;
    }


    public function create(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->cartRepository->getCart([
            'cartProducts.product',
            'cartProducts.configs'
        ]);




        return view('shop::order.create')->with([
            'cart' => $cart,
            'total' => $this->total($cart->cartProducts),
            'shipping_types' => config('shop.shipping_types')
        ]);
    }

    public function store(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->cartRepository->getCart([
            'cartProducts.product.images',
            'cartProducts.configs'
        ]);

        $order = new Order;

        $order->fill($request->all());

        $order->fill(['cart' => $cart->toJson()]);

        $order->save();

        return view('shop::order.confirm')->with([
            'order' => $order,
        ]);
    }


    public function confirm(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->cartRepository->getCart([
            'cartProducts.product.images',
            'cartProducts.configs'
        ]);


    }

    public function cancel(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->cartRepository->getCart([
            'cartProducts.product.images',
            'cartProducts.configs'
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