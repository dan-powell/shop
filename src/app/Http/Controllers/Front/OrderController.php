<?php namespace DanPowell\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\OrderRepository;
use DanPowell\Shop\Repositories\CartRepository;

use DanPowell\Shop\Models\Order; // TEMP

use DanPowell\Shop\Http\Requests\OrderStoreRequest;

use Illuminate\Foundation\Validation\ValidatesRequests;

use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\CartTrait;

class OrderController extends BaseController
{

    use ImageTrait;
    use CartTrait;
    use ValidatesRequests;

    protected $repository;
    protected $cartItemRepository;
    protected $cartRepository;

    public function __construct(OrderRepository $OrderRepository, CartRepository $CartRepository)
    {
        $this->repository = $OrderRepository;
        $this->cartRepository = $CartRepository;
    }


    public function create()
    {
        // Get the cart
        $cart = $this->cartRepository->getCart(['cartItems.product.extras']);

        // Check that we have items
        if (count($cart->cartItems) <= 0) {
            return redirect()->back()->withInput(['warning' => 'Please add some items to your cart']);
        }

        // Return the view
        return view('shop::front.order.create.orderCreate')->with([
            'cart' => $cart,
            'itemsGrouped' => $this->groupCartItemsByProduct($cart->cartItems),
            'shipping_options' => $this->repository->getShippingOptions($cart),
            'order' => session()->get('order', [])
        ]);

    }

    public function store(OrderStoreRequest $request)
    {
        // Save order values to session
        session()->put('order', $request->all());

        $order = new Order;

        $order->fill($request->all());

        // Get the cart
        $cart = $this->cartRepository->getCart(['cartItems.product']);

        // Check the cart items
        $verify = $this->verifyCart($cart);


        if(!$verify['check']) {
            return redirect()->back()->withInput($verify['messages']);
        }

        

        $order_shipping = null;
        // Find the shipping type and save to cart
        foreach(config('shop.shipping_types') as $shipping_type) {
            if ($shipping_type['id'] == $request->get('shipping_type')) {
                $order_shipping = $shipping_type;
            }
        }

        $order->fill([
            'cart' => $cart,
            'total' => $cart->price_total + $order_shipping['price'],
            'shipping_type' => $order_shipping
        ]);

        $order->save();

        return view('shop::front.order.confirm.orderConfirm')->with([
            'order' => $order,
            'shipping_price' => config('shop.currency.symbol') . number_format($order_shipping['price'], 2)
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
            'amount'    => $order->total,
            'returnUrl' => 'http://google.co.uk',
            'cancelUrl' => 'http://google.co.uk',
            'description' => $desc,
            'transactionId' => $order->id,
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


    }





    private function verifyCart($cart)
    {

        $check = true;
        $messages = [];

        // Check we actually have items
        if(count($cart->cartItems) <= 0) {
            $check = false;
            $messages['warning'] = 'There are no items in your cart.';
        }


        // Check the validity of all cart items
        $cart->cartItems->each(function($item){

            if (!$item->valid){
                $check = false;
                $messages['warning'] = 'An item in your cart is invalid. Please either remove or replace it.';
            }

        });

        foreach($cart->cartItems->groupBy('product_id') as $itemGroup) {

            $cartQuantity = 0;

            foreach($itemGroup as $item) {
                $cartQuantity += $item->quantity;
            }

            $product = $itemGroup->first()->product;

            // Check product stock
            if (!$product->checkStock($cartQuantity)) {
                $check = false;
                $messages['warning'] = 'We don\'t have enough of this product in stock.';
            }

            // Check product extras stock
            foreach($product->extras as $extra) {
                if (!$extra->checkStock($cartQuantity)) {
                    $check = false;
                    $messages['warning'] = 'We don\'t have enough of this product extra in stock.';
                }
            };

        };

        return [
            'check' => $check,
            'messages' => $messages
        ];


        // Check that item products exist

        // Check that item options exist

        // Check that item extras exist


        // Check that item product has stock


        // Check that item extras have stock




    }


}
