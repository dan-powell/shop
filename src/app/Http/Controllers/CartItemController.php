<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

use Illuminate\Foundation\Validation\ValidatesRequests;

use DanPowell\Shop\Models\CartItem;


use Illuminate\Support\MessageBag;

class CartItemController extends BaseController
{

	use ValidatesRequests;

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
		$cart = $this->cartRepository->getCart(['cartItems']);

		// Find product to be added
		$product = $this->productPublicRepository->getById($request->get('product_id'), ['optionGroups.options', 'personalisations']);



		// Validate input
		$this->validate($request, CartItem::rules($product));





		$item = new Collection;

		$options = $this->getOptions($product, $request->get('optionGroup'));

        $personalisations = $this->getPersonalisations($product, $request->get('personalisation'));

        $sub = $this->calcSub($product, $options);


		// Find all items of the same product
		$findItem = $cart->cartItems->where(
			'product_id', '=', $product->id
		)->all();

		// Get the total quantity of product in the cart
		if($findItem) {
			$totalquantity = $request->get('quantity');
			// Sum all cart items linked to product
			foreach($findItem as $item) {
				$totalquantity += $item->quantity;
			}
		} else {
			$totalquantity = $request->get('quantity');
		}


		// Check stock
		if(!$product->allow_negative_stock) {
			if($totalquantity > $product->stock) {
				dd('too many!');
				return redirect()->route('shop.product.show', $product->slug);
			}
		}

		foreach ($options as $option) {
			if (!$option->allow_negative_stock && isset($option->option->stock) && $totalquantity > $option->option->stock) {
				dd('too many options!');
				return redirect()->route('shop.product.show', $product->slug);
			}
		}




		// Check if this item config is already saved & update quantity...
		$findItem = CartItem::where([
			'cart_id' => $cart->id,
			'product_id' => $product->id,
			'options' => $options->toJson(),
			'personalisations' => $personalisations->toJson(),
			'sub_total' => $sub,
		])->increment('quantity', $request->get('quantity'));

		// If we did'nt found the same item...
		if(!$findItem) {

			// .. Save a new item
			$cartItem = new CartItem;
			$cartItem->fill([
				'cart_id' => $cart->id,
				'product_id' => $product->id,
				'options' => $options->toJson(),
				'personalisations' => $personalisations->toJson(),
				'sub_total' => $sub,
				'quantity' => $request->get('quantity')
			]);

			$cartItem->save();

		}



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

		$personalisations = $product->personalisations->filter(function ($m) use ($submittedPersonalisations) {
			if (isset($submittedPersonalisations[$m->id]) && $submittedPersonalisations[$m->id] != '') {
				return $m;
			}
		});

		// Add personalisation values to product
		$personalisations->each(function ($m) use ($submittedPersonalisations) {
			$m->value = $submittedPersonalisations[$m->id];
		});

		return $personalisations;
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

		CartItem::where('cart_id', '=', $cart->id)->where('id', '=', $id)->delete();

		return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Item has been removed from your cart']);
	}



}
