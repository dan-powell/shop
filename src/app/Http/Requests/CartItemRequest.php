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
class CartItemRequest extends Request
{

    protected $product;
    protected $cartItem;
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

    }

    /**
     * Create an array of message for Laravel's validator
     * @return array
     */
    public function messages()
    {

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
    protected function getRuleOption($option)
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
    protected function getRuleQuantity($modifier = 0)
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

        return 'required|integer|min:1|max:' . ($max + $modifier);
    }

}