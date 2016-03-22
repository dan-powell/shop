<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;
use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

/**
 * Provide rules for the
 * Class CartItemStoreRequest
 * @package DanPowell\Shop\Http\Requests
 */
class CartItemStoreRequest extends Request
{

    protected $product;
    protected $productPublicRepository;
    protected $cartItemRepository;
    protected $cartRepository;

    public function __construct(
        CartRepository $CartRepository,
        ProductPublicRepository $ProductPublicRepository,
        CartItemRepository $CartItemRepository)
    {
        $this->productPublicRepository = $ProductPublicRepository;
        $this->cartItemRepository = $CartItemRepository;
        $this->cartRepository = $CartRepository;
    }

    /**
     * Always authorize this request
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


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

    /**
     * Get the Product we are trying to add (once).
     * @return mixed
     */
    public function getProduct() {
        if (!$this->product) {
            $this->product = $this->productPublicRepository->getById($this->get('product_id'), ['extras.options', 'options']);
        }
        return $this->product;
    }

    /**
     * Return the rule string for a particular Option
     * @param $option
     * @return string
     */
    private function getRuleOption($option)
    {
        // Start creating rules string
        $rule = '';
        // Make sure the radio & selects exist and have legit values
        if ($option->type == 'radio' || $option->type == 'select') {
            $rule .= 'required|in:';
            foreach ($option->config as $value) {
                $rule .= $value . ',';
            }
        }
        return 'string|' . $rule;
    }

    /**
     * Return the rule string for quantity input
     * @return string
     */
    private function getRuleQuantity()
    {

        // Get the product
        $product = $this->getProduct();

        // Get the cart
        $cart = $this->cartRepository->getCart();

        // Count the number of items in cart matching product
        $totalProductQuantityInCart = $cart->getCartItemsByProductIdCount($product->id);

        if ($product->allow_negative_stock) {
            $max = config('shop.maxProductCartQuantity') - $totalProductQuantityInCart;
        } else {
            $max = $product->stock - $totalProductQuantityInCart;
        }

        return 'required|integer|min:1|max:' . $max;
    }

}