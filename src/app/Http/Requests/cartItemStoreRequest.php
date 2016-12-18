<?php namespace DanPowell\Shop\Http\Requests;

/**
 * Provide rules for the
 * Class CartItemStoreRequest
 * @package DanPowell\Shop\Http\Requests
 */
class CartItemStoreRequest extends CartItemRequest
{

    /**
     * Create an array of rules for Laravel's validator
     * @return array
     */
    public function rules()
    {
        $product = $this->getProduct();

        $rules = [];

        // TODO: This is all kinds of horrible

        // Add rules for the Product options
        foreach($product->options as $option) {
            $rules['option.' . $option->id] = $this->getRuleOption($option);
        };

        // Set the Extras (filter out extras user has not selected)
        $submittedExtras = $this->get('extra');
        $product->extras = $product->extras->filter(function ($extra) use ($submittedExtras) {
            if (isset($submittedExtras[$extra->id])) {
                return $extra;
            }
        });

        // Validate the Extra options
        foreach($product->extras as $extra) {
            foreach($extra->options as $option) {
                $rules['option.' . $option->id] = 'required_with:extra.' . $extra->id  . '|' . $this->getRuleOption($option);
            }
        };

        // Validate the quantities
        $rules['quantity'] = $this->getRuleQuantity();

        return $rules;
    }

    /**
     * Create an array of message for Laravel's validator
     * @return array
     */
    public function messages()
    {

        $product = $this->getProduct();

        $messages = [];

        // Add rules for the Product options
        foreach($product->options as $option) {

            $messages['option.' . $option->id . '.in'] = 'The ' . $option->title . ' option is invalid.';
            $messages['option.' . $option->id . '.required'] = 'The ' . $option->title . ' option is required.';
            $messages['option.' . $option->id . '.string'] = 'The ' . $option->title . ' option must be text.';
        };

        // Validate the Extra options
        foreach($product->extras as $extra) {
            foreach($extra->options as $option) {
                $messages['option.' . $option->id . '.in'] = 'The ' . $option->title . 'option is invalid';
                $messages['option.' . $option->id . '.required_with'] = 'The ' . $option->title . ' option is required with this extra.';
                $messages['option.' . $option->id . '.string'] = 'The ' . $option->title . ' option must be text.';
            }
        };

        $messages['quantity.max'] = trans('shop::cartItem.rules.noProductStock');

        return $messages;
    }

}