<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\OrderRepository;

class OrderConfirmRequest extends Request
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

        return [
            'id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [];
    }

    /**
     * Get the Cart we are trying to add (once).
     * @return mixed
     */
    public function getCart() {

        if (!$this->cart) {
            // We eager load a lot of relations here because we know that these are probably going to be used by other methods when processing order.
            $this->cart = $this->cartRepository->getCart(['cartItems']);
        }
        return $this->cart;
    }
}