<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;



use DanPowell\Shop\Models\CartItem;


use Illuminate\Support\MessageBag;

class CartProductController extends BaseController
{

	protected $cartRepository;
	protected $productPublicRepository;

	public function __construct(CartRepository $CartRepository, ProductPublicRepository $ProductPublicRepository)
	{
		$this->cartRepository = $CartRepository;
		$this->productPublicRepository = $ProductPublicRepository;
	}

	public function store(Request $request)
	{

		// Get the cart (or make one)
		$cart = $this->cartRepository->getCart();

		// Find product to be added
		$product = $this->productPublicRepository->getById($request->get('product_id'), ['optionGroups.options', 'personalisations']);


		$item = new Collection;

        

		$options = $this->getOptions($product, $request->get('optionGroup'));
		
        $personalisations = $this->getPersonalisations($product, $request->get('personalisation'));
		
        $sub = $this->calcSub($product, $options);

		// Get the quantity ordered
        if($request->get('quantity') != null){
			$loop = $request->get('quantity');

			// Limit to 10
			if($loop > 10) {
				$messages['warning'] = 'Maximum quantity exceeded';
				$loop = 10;
			}

		} else {
			$loop = 1;
		}

		// Create a multidimensional array of products
		$cartItems = [];
		for($i=0; $i < $loop; $i++){

            // Make new
			array_push($cartItems, [
    			'cart_id' => $cart->id,
				'product_id' => $product->id,
				'options' => $options->toJson(),
				'personalisations' => $personalisations->toJson(),
				'sub_total' => $sub
			]);


			// Validate options
			// Check that the option exists AND is related to the product we want to save
			// Loop of the Product optionGroups and find one with same key as in post data option
			// Loop of the optionGroup options and find one with same key as in post data option

			// Validate personalisations
			// * Same as options

		}

		// Save all cart items in one go.
		$cartItem = new CartItem;
		$cartItem->insert($cartItems);

		return redirect()->route('shop.cart.index');
	}




    private function getOptions($product, $submittedOptionGroups) {
        
        //if(isset($product->optionGroups) && count($product->optionGroups)) {

    		// Filter out optionGroups that don't have options
    		$optionGroups = $product->optionGroups->filter(function ($m) {
    			if (isset($m->options) && count($m->options)) {
    				return $m;
    			};
    		});

    		// Get the chosen options and their values
    		$optionGroups->each(function ($m) use ($submittedOptionGroups) {
    			if (isset($submittedOptionGroups[$m->id]) && $submittedOptionGroups[$m->id] != '') {
    				$m->option = $m->options->keyBy('id')->get($submittedOptionGroups[$m->id]);
    			}
    		});
    		
    		return $optionGroups;
            
        //} else {
        //    return null;
        //}
        
        
    }


    private function getPersonalisations($product, $submittedPersonalisations) {
		//if(isset($product->personalisations) && count($product->personalisations)) {

    		// Get the personalisation values submitted & pair with DB data
    		//if (isset($submittedPersonalisations) && count($submittedPersonalisations)) {
    			$personalisations = $product->personalisations->filter(function ($m) use ($submittedPersonalisations) {
    				if (isset($submittedPersonalisations[$m->id]) && $submittedPersonalisations[$m->id] != '') {
    					return $m;
    				}
    			});
    		//};
    
    		// Add personalisation values to product
    		$personalisations->each(function ($m) use ($submittedPersonalisations) {
    			$m->value = $submittedPersonalisations[$m->id];
    		});
    		
    		return $personalisations;
		
		//} else {
            //return null;
        //}
    }



	private function calcSub($product, $options)
	{

		$addMeUp = [];

		// Add the base item price
		array_push($addMeUp, $product->price);
				
		foreach($options as $optionGroup) {
			array_push($addMeUp, $optionGroup->option->price_modifier);
		}

		return array_sum($addMeUp);
	}




	public function update($id, Request $request)
	{

		$this->destroy($id, $request);

		$this->store($request);

		return redirect()->route('shop.cart.index')->withInput(['success' => 'Product has been updated']);

	}




	public function destroy($id, Request $request)
	{
		$cart = $this->cartRepository->getCart(['cartItems.product']);

		CartItem::where('cart_id', '=', $cart->id)->where('product_id', '=', $id)->delete();

		return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Product has been removed from your cart']);
	}
}
