<?php namespace DanPowell\Shop\Http\Requests;

/**
 * Provide rules for the cart item updates
 * Class CartItemUpdateRequest
 * @package DanPowell\Shop\Http\Requests
 */
class CartItemUpdateRequest extends CartItemRequest
{
    /**
     * Get the CartItem we are trying to update (once).
     * @return mixed
     */
    public function getCartItem() {

        if (!$this->cartItem) {
            $this->cartItem = $this->cartItemRepository->getbyId($this->route('item'));
        }
        return $this->cartItem;
    }

    /**
     * Get the Product we are trying to add (once).
     * @return mixed
     */
    public function getProduct() {

        if (!$this->product) {
            $this->product = $this->productPublicRepository->getById($this->getCartItem()->product_id);
        }
        return $this->product;
    }

    /**
     * Create an array of rules for Laravel's validator
     * @return array
     */
    public function rules()
    {

        $rules = [];

        // Validate the quantities
        $rules['quantity'] = $this->getRuleQuantity($this->getCartItem()->quantity);

        return $rules;
    }

    /**
     * Create an array of message for Laravel's validator
     * @return array
     */
    public function messages()
    {

        $messages = [];

        $messages['quantity.max'] = trans('shop::cartItem.rules.noProductStock');

        return $messages;
    }


}

