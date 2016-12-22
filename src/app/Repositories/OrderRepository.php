<?php namespace DanPowell\Shop\Repositories;

use DanPowell\Shop\Models\Order;

class OrderRepository extends AbstractRepository
{

    protected $model;
    protected $cartRepository;

    public function __construct(CartRepository $CartRepository)
    {
        $this->cartRepository = $CartRepository;
        $this->model = new Order();
    }

    /**
     * Return an array of shipping options that match the
     * @param null $cart
     * @return array
     */
    public function getShippingOptions()
    {
        // If the cart Collection is not passed in, let's get it.
        $cart = app('cart')->cart;

        // Set the cart value to use depending upon the config
        if (config('shop.shipping_tier_property') == 'weight') {
            $value = round($cart->weight_total, 2);
        } else {
            $value = round($cart->price_total, 2);
        }

        // Loop over the shipping options array and return any that encompass given value
        $arr = [];
        foreach(config('shop.shipping_types') as $option) {

            $option['price_string'] = config('shop.currency.symbol') . number_format($option['price'], 2);

            if($option['min'] <= $value && ($option['max'] >= $value || $option['max'] == 0)) {
                $arr[] = $option;
            }
        }
        return $arr;

    }

}