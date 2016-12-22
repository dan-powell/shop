<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\OrderRepository;

class OrderStoreRequest extends Request
{

    protected $orderRepository;
    protected $cartRepository;
    protected $cart;

    public function __construct(OrderRepository $orderRepository, CartRepository $cartRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function authorize()
    {
        return true;
    }

    /**
     * @return array
     */
    public function rules()
    {

        $valid_shipping = [];
        foreach($this->orderRepository->getShippingOptions() as $option) {
            $valid_shipping[] = $option['id'];
        }

        $valid_shipping = implode(",", $valid_shipping);

        $countries_billing = implode(",", config('shop.countries_allow_billing'));
        $countries_shipping = implode(",", config('shop.countries_allow_shipping'));

        return [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'billingPhone' => 'required|string',
            'billingAddress1' => 'required|string',
            'billingAddress2' => 'string',
            'billingCity' => 'required|string',
            'billingPostcode' => 'required|string',
            'billingState' => 'required|string',
            'billingCountry' => 'required|string|in:' . $countries_billing,
            'shippingAddress1' => 'required|string',
            'shippingAddress2' => 'string',
            'shippingCity'  => 'required|string',
            'shippingPostcode' => 'required|string',
            'shippingState' => 'required|string',
            'shippingCountry' => 'required|string|in:' . $countries_shipping,
            'instructions' => 'string',
            'shipping_type' => 'required|in:' . $valid_shipping
        ];
    }

    public function messages()
    {
        return [
            'shippingCountry.in' => 'We do not currently support shipping to this country.',
            'billingCountry.in' => 'We do not currently support payments from this country.'
        ];
    }

    /**
     * Get the Cart we are trying to add (once).
     * @return mixed
     */
    public function getCart() {

        if (!$this->cart) {
            // We eager load a lot of relations here because we know that these are6 probably going to be used by other methods when processing order.
            $this->cart = $this->cartRepository->getCart(['cartItems.product', 'cartItems.extras.options', 'cartItems.options']);
        }
        return $this->cart;
    }

}