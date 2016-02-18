<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;
use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

class CartItemStoreRequest extends Request
{

    protected $product;
    protected $productPublicRepository;
    protected $cartItemRepository;

    //protected $productPublicRepository;

    public function __construct(ProductPublicRepository $ProductPublicRepository, CartItemRepository $cartItemRepository)
    {
        $this->productPublicRepository = $ProductPublicRepository;
        $this->cartItemRepository = $cartItemRepository;
    }


//    public function validate()
//    {
//        $v = $this->getValidatorInstance();
//
//        $v->sometimes('quantity', 'url', function($input)
//        {
//            return $input->quantity == 50;
//        });
//
//        if (! $this->passesAuthorization()) {
//            $this->failedAuthorization();
//        } elseif (! $v->passes()) {
//            $this->failedValidation($v);
//        }
//    }


    public function authorize()
    {
        return true;
    }

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

    public function getProduct() {
        if (!$this->product) {
            $this->product = $this->productPublicRepository->getById($this->get('product_id'), ['extras.options', 'options']);
        }
        return $this->product;
    }

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

    private function getRuleQuantity()
    {

        // Get the product
        $product = $this->getProduct();

        if ($product->allow_negative_stock) {
            $max = config('shop.maxProductCartQuantity') - $this->cartItemRepository->getTotalProductQuantityInCart($product->id);
        } else {
            $max = $product->stock - $this->cartItemRepository->getTotalProductQuantityInCart($product->id);
        }

        return 'required|integer|min:1|max:' . $max;
    }

}