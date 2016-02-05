<?php namespace DanPowell\Shop\Http\Requests;

use App\Http\Requests\Request;
use DanPowell\Shop\Repositories\ProductPublicRepository;

class ProcessCartItemRequest extends Request
{

    protected $product;
    protected $productPublicRepository;


    //protected $productPublicRepository;

    public function __construct(ProductPublicRepository $ProductPublicRepository)
    {
        $this->productPublicRepository = $ProductPublicRepository;
    }


    public function authorize()
    {
        return true;
    }


    private function getProduct() {

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






}