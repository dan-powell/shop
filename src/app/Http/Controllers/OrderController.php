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

        $cart = $this->cartRepository->getCart([
            'cartProducts.product',
            'cartProducts.configs'
        ]);
        
        $order = Order::find($request->get('id'));
        

        $gateway = \Omnipay::gateway('paypal');


        $settings = $gateway->getDefaultParameters();

        //dd($settings);

        $desc = '';
        foreach($cart->cartProducts as $cartProduct) {
            $desc .= '| ' . $cartProduct->product->title;
        }


        $card = \Omnipay::creditCard($order->toArray());
        

        $response = \Omnipay::purchase([
            'currency' => 'GBP',
            'amount'    => '100.00',
            'returnUrl' => 'http://google.co.uk',
            'cancelUrl' => 'http://google.co.uk',
            'description' => $desc,
            'transactionId' => $cart->id,
            'card' => $card,
        ])->send();

        //dd($response);

//        $purchaseRequest = $this->omnipay->purchase($data);
//
//        // Grab the parameters
//        $purchaseParameters = $purchaseRequest->getData();
//
//        // Add our additional parameters
//        $purchaseParameters['MC_paymentType'] = 'payment';
//
//        // Send off the request
//        $response = $purchaseRequest->sendData($purchaseParameters);

        // Check we got a redirect response
        if ($response->isRedirect()) {
            // If so redirect the user
            $response->redirect();
        } else {
            // Broken data
            dd($response);
            throw new Exception();
        }




//        $cart = $this->cartRepository->getCart([
//            'cartProducts.product.images',
//            'cartProducts.configs'
//        ]);


    }

    public function cancel(Request $request)
    {






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
