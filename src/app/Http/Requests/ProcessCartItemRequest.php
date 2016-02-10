<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;
use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

class ProcessCartItemRequest extends Request
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


    public function authorize()
    {
        return true;
    }


    public function getProduct() {

        if (!$this->product) {
            $this->product = $this->productPublicRepository->getById($this->get('product_id'), ['extras.options', 'options']);
        }

        return $this->product;

    }


    /**
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

        return $messages;
    }

    /**
     * @return array
     */
    public function rules()
    {

        $product = $this->getProduct();




















        // Set the Product option values
        $submittedOptions = $this->get('option');
        $product->options->each(function ($option) use ($submittedOptions) {
            if (isset($submittedOptions[$option->id])) {
                $option->value = $submittedOptions[$option->id];
            }
        });




        // Set the Extras (filter out extras user has not selected)
        $submittedExtras = $this->get('extra');
        $product->extras = $product->extras->filter(function ($extra) use ($submittedExtras) {
            if (isset($submittedExtras[$extra->id])) {
                return $extra;
            }
        });

        // Set the chosen Extras values
        $product->extras->each(function ($extra) use ($submittedOptions) {
            $extra->options->each(function ($option) use ($submittedOptions) {
                $option->value = $submittedOptions[$option->id];
            });
        });


        // Find all items of the same product, so we can calculate the total quantity in the cart
        $quantityToCheck = $this->getTotalProductQuantityInCart($product->id) + $this->get('quantity');


        // Check product stock
        if(!$product->checkStock($quantityToCheck)) {
            session()->flash('alert-warning', 'Not enough product stock available.');
            //return redirect()->route('shop.product.show', $product->slug);
        }

        // Check product extras stock
        $product->extras->each(function ($extra) use ($quantityToCheck, $product) {
            if(!$extra->checkStock($quantityToCheck)) {
                session()->flash('alert-warning', 'Not enough stock available to add this extra.');
                //return redirect()->route('shop.product.show', $product->slug);
            }
        });








        $rules = [];

        // Add rules for the Product options
        foreach($product->options as $option) {
            // Start creating rules string
            $rule = 'string';
            // Make sure the radio & selects exist and have legit values
            if($option->type == 'radio' || $option->type == 'select') {
                $rule .= '|required|in:';
                foreach ($option->config as $value) {
                    $rule .= $value . ',';
                }
            }
            // Add rule to array
            $rules['option.' . $option->id] = $rule;
        };

        // Validate the Extra options
        foreach($product->extras as $extra) {
            //$rules['extra.' . $extra->id] = 'in:';
            foreach($extra->options as $option) {
                // Start creating rules string
                $rule = 'string|required_with:extra.' . $extra->id;

                // This should only apply to radios and selects where values are pre-defined
                if ($option->type == 'radio' || $option->type == 'select') {
                    $rule .= '|in:';
                    foreach ($option->config as $value) {
                        $rule .= $value . ',';
                    }
                }
                // Add rule to array
                $rules['option.' . $option->id] = $rule;
            }
        };

        // Validate the quantities
        $rules['quantity'] = 'required|integer|min:1|max:99';

        return $rules;
    }


    public function getTotalProductQuantityInCart($product_id)
    {
        // Find all items of the same product, so we can calculate the total quantity in the cart
        $items = $this->cartItemRepository->getCartItems()->where(
            'product_id', $product_id
        )->all();

        // Get the total quantity of product in the cart
        if($items) {
            $quantity = 0;
            // Sum all cart items linked to product
            foreach($items as $item) {
                $quantity += $item->quantity;
            }

            return $quantity;

        } else {
            return 0;
        }
    }



}