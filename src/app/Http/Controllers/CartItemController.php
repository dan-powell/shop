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
		$product = $this->productPublicRepository->getById($request->get('product_id'), ['extras.options', 'options']);



		// Validate input
		$this->validate($request, CartItem::rules($product));




		//$options = $this->getOptions($product, $request->get('option'));

		$submittedOptions = $request->get('option');
		$product->options->each(function ($option) use ($submittedOptions) {
			if (isset($submittedOptions[$option->id]) && $submittedOptions[$option->id] != '') {
				$option->value = $submittedOptions[$option->id];
			}
		});

		$submittedExtras = $request->get('extra');
		$product->extras = $product->extras->filter(function ($extra) use ($submittedExtras) {
			if (isset($submittedExtras[$extra->id]) && $submittedExtras[$extra->id] != '') {
				return $extra;
			}
		});

		$product->extras->each(function ($extra) use ($submittedOptions) {
			$extra->options->each(function ($option) use ($submittedOptions) {
				$option->value = $submittedOptions[$option->id];
			});
		});


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


		// Check extras stock
		foreach ($product->extras as $extra) {
			if (!$extra->allow_negative_stock && isset($extra->stock) && $totalquantity > $extra->stock) {
				dd('too many options!');
				return redirect()->route('shop.product.show', $product->slug);
			}
		}



		// Check if this item config is already saved & update quantity...
		$findItem = CartItem::where([
			'cart_id' => $cart->id,
			'product_id' => $product->id,
			'options' => $product->options,
			'extras' => $product->extras
		])->increment('quantity', $request->get('quantity'));

		// If we did'nt found the same item...
		if(!$findItem) {

			// .. Save a new item
			$cartItem = new CartItem;
			$cartItem->fill([
				'cart_id' => $cart->id,
				'product_id' => $product->id,
				'options' => $product->options,
				'extras' => $product->extras,
				'quantity' => $request->get('quantity')
			]);

			$cartItem->save();

		}



		return redirect()->route('shop.cart.index');
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
