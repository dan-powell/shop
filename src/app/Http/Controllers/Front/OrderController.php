<?php namespace DanPowell\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\OrderRepository;
use DanPowell\Shop\Repositories\CartRepository;

use DanPowell\Shop\Http\Requests\OrderStoreRequest;
use DanPowell\Shop\Http\Requests\OrderConfirmRequest;

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
            \Notification::warning('Please add some items to your cart');
            return redirect()->back();
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

        $order = $this->repository->makeModel();
        $order->fill($request->all());

        // We've already queried the cart in the request, so let's use that instance
        $cart = $request->getCart();

        // Check the cart items
        $verify = $this->cartRepository->validateCart($cart);
        if(!$verify['check']) {
            return redirect()->back();
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


    public function confirm(OrderConfirmRequest $request)
    {

        $cart = $request->getCart();

        // Check the cart items
        $verify = $this->cartRepository->validateCart($cart);
        if(!$verify['check']) {
            return redirect()->back();
        }

        // Get the order
        $order = $this->repository->getById($request->get('id'));

        //$gateway = \Omnipay::gateway('paypal');
        //dd($gateway->getDefaultParameters());

        $desc = '';
        foreach($cart->cartItems as $item) {
            $desc .= "> " . $item->product->title . "\r\n";
        }

        $card = \Omnipay::creditCard($order->toArray());

        //dd($card);

        $response = \Omnipay::purchase([
            'currency' => 'GBP',
            'amount'    => $order->total,
            'returnUrl' => route('shop.order.show', $order->id),
            'cancelUrl' => route('shop.order.cancel', $order->id),
            'description' => $desc,
            'transactionId' => $order->id,
            'card' => $card,
        ])->send();

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

    public function cancel($id)
    {
        return view('shop::front.order.cancel.orderCancel');

    }


    // TODO - Make this secure by checking that the user has the corresponding session ID for this order
    public function show($id)
    {

        $order = $this->repository->getById($id);

        return view('shop::front.order.show.orderShow')->with([
            'order' => $order
        ]);
    }






}
