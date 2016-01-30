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
use DanPowell\Shop\Traits\CartTrait;

class OrderController extends BaseController
{

    use ImageTrait;
    use CartTrait;

    protected $repository;
    protected $cartRepository;

    public function __construct(OrderRepository $OrderRepository, CartRepository $CartRepository)
    {
        $this->repository = $OrderRepository;
        $this->cartRepository = $CartRepository;
    }


    public function create(Request $request)
    {
        $cart = $this->cartRepository->getCart(['cartItems.product']);

        return view('shop::order.create')->with([
            'itemsGrouped' => $this->groupCartItemsByProduct($cart->cartItems),
            'total' => $this->getCartTotal($cart->cartItems),
            'shipping_types' => config('shop.shipping_types')
        ]);
        
    }

    public function store(Request $request)
    {
        $cart = $this->cartRepository->getCart(['cartItems.product']);

        $order = new Order;

        $order->fill($request->all());

        $order->fill([
            'cart' => $cart->toJson(),
            'total' => $this->getCartTotal($cart->cartItems)
        ]);

        $order->save();

        return view('shop::order.confirm')->with([
            'order' => $order
        ]);
        
    }


    public function confirm(Request $request)
    {

        $cart = $this->cartRepository->getCart(['cartItems.product']);
        
        $order = Order::find($request->get('id'));
        

        $gateway = \Omnipay::gateway('paypal');


        $settings = $gateway->getDefaultParameters();

        //dd($settings);

        $desc = '';
        foreach($cart->cartItems as $item) {
            $desc .= "> " . $item->product->title . "\r\n";
        }


        $card = \Omnipay::creditCard($order->toArray());
        

        $response = \Omnipay::purchase([
            'currency' => 'GBP',
            'amount'    => $this->getCartTotal($cart->cartItems),
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



    }

    public function cancel(Request $request)
    {

        $cart = $this->cartRepository->getCart([
            'cartProducts.product.images',
            'cartProducts.configs'
        ]);

    }

}
