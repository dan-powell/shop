<?php namespace DanPowell\Shop\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\ProductRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;
use DanPowell\Shop\Models\CartOption;
use DanPowell\Shop\Models\CartPersonalisation;

class CartController extends Controller {


    protected $productRepository;


    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }


    public function index(Request $request)
    {

        // Load the cart (and relations)
        // If there is'nt a cart for this session, make one

        $cart = $this->getCart(['cartProducts.cartOptions.option.optionGroup', 'cartProducts.product', 'cartProducts.cartPersonalisations.personalisation']);

        // Group products together by type
        // Ideally, it would be great if only items with options were displayed on thier own - identical products should be displayed with quantity

        $cart->groupedProducts = $cart->cartProducts->groupBy('product_id');


        return view('shop::cart.index')->with([
            'cart' => $cart
        ]);
    }



    public function getCart($with = [])
    {
        $cart = Cart::where('session_id', '=', \Session::getId())->with($with)->first();

        // if no cart has been found, then create one
        if(!$cart) {
            $cart = $this->createCart();
        }

        return $cart;
    }


    public function createCart()
    {

        // Update the item with request data
        $cart = new Cart;

        $cart->fill([
            'session_id' => \Session::getId()
        ]);

        $cart->save();

        return $cart;

    }


    public function store(Request $request)
    {

        // Get the cart (or make one)
        $cart = $this->getCart();

        // Find the product to be added
        $product = $this->productRepository->getById(
            $request->get('product_id')
        );


        // create new product
        $cart_product = new CartProduct;


        // validate the product against model

        $cart_product->fill([
            'product_id' => $product->id,
            'cart_id' => $cart->id
        ]);


        // Validate options
        // Check that the option exists AND is related to the product we want to save
        // Loop of the Product optionGroups and find one with same key as in post data option
        // Loop of the optionGroup options and find one with same key as in post data option

        // Validate personalisations
        // * Same as options


        // Save the cart
        $cart_product->save();
        
        



        $option_fields = $request->get('optionGroup');

        if($option_fields != null && count($option_fields)) {

            foreach($option_fields as $option) {


                $arr = [
                    'option_id' => $option
                ];

                //dd($arr);
            
                $cartOption = new CartOption;
                
                $cartOption->fill($arr);
            
                $cart_product->cartOptions()->save($cartOption);
            }

        }



        $personalisation_fields = $request->get('personalisation');

        if($personalisation_fields != null && count($personalisation_fields)) {

            foreach($personalisation_fields as $key => $personalisation_field) {


                $arr = [
                    'personalisation_id' => $key,
                    'value' => $personalisation_field
                ];

                //dd($arr);

                $cartPersonalisation = new CartPersonalisation;

                $cartPersonalisation->fill($arr);

                $cart_product->cartOptions()->save($cartPersonalisation);
            }

        }
        


        return view('shop::cart.index')->with([
            'data2' => $request->all(),
        ]);


    }

}
