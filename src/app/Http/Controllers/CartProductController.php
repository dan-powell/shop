<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;


use DanPowell\Shop\Models\CartProduct;


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
		$cart = $this->cartRepository->getCart(['cartProducts']);

		$id = $request->get('product_id');


		$product = $this->productPublicRepository->getById($id, ['optionGroups.options', 'personalisations']);

		$cartProduct = $cart->cartProducts->keyBy('product_id')->get($id);

		//dd($cartProduct);

		if(!$cartProduct) {

			// Make new

			$cartProduct = new CartProduct;

			$cartProduct->fill([
				'cart_id' => $cart->id,
				'product_id' => $product->id,
				'price' => $product->price,
			]);

			$cartProduct->save();

		}



		$optionGroups = $product->optionGroups->filter(function($m){
			if(isset($m->options) && count($m->options)) {
				return $m;
			};
		});

		$submittedOptionGroups = $request->get('optionGroup');

		$optionGroups->each(function($m) use ($submittedOptionGroups) {
			$m->option = $m->options->keyBy('id')->get($submittedOptionGroups[$m->id]);
		});


		//if($request->get('personalisation') != null && count($request->get('personalisation'))) {

			$submittedPersonalisations = $request->get('personalisation');

			$product->personalisations = $product->personalisations->filter(function ($m) use ($submittedPersonalisations) {
				if($submittedPersonalisations[$m->id] != '') {
					return $m;
				}
			});


			$product->personalisations->each(function ($m) use ($submittedPersonalisations) {
				$m->value = $submittedPersonalisations[$m->id];
			});






		if($request->get('quantity') != null){
			$loop = $request->get('quantity');

			if($loop > 10) {
				$messages['warning'] = 'Maximum quantity exceeded';
				$loop = 10;
			}

		} else {
			$loop = 1;
		}

		$arr = [];

		for($i=0; $i < $loop; $i++){


			array_push($arr, [
				'cart_product_id' => $cartProduct->id,
				'options' => $optionGroups->toJson(),
				'personalisations' => $product->personalisations->toJson(),
				'sub_total' => $this->calcSub($product, $request->get('optionGroup'), $request->get('personalisation'))
			]);


			// Validate options
			// Check that the option exists AND is related to the product we want to save
			// Loop of the Product optionGroups and find one with same key as in post data option
			// Loop of the optionGroup options and find one with same key as in post data option

			// Validate personalisations
			// * Same as options

		}

		//$cart_product->insert($arr);





		$cartProduct->cartProductConfigs()->insert($arr);




		return redirect()->route('shop.cart.index', 301);

	}



	private function calcSub($product, $submittedOptionGroups, $personalisations)
	{

		$arr = [];

		array_push($arr, $product->price);


		$optionGroups = $product->optionGroups->filter(function($m){
			if(isset($m->options) && count($m->options)) {
				return $m;
			};
		});


		foreach($optionGroups as $optionGroup) {
			array_push($arr, $optionGroup->options->keyBy('id')->get($submittedOptionGroups[$optionGroup->id])->price_modifier);
		}

		return array_sum($arr);

	}




	public function update($id, Request $request)
	{

		$this->destroy($id, $request);

		$this->store($request);

		return redirect()->route('shop.cart.index', 301)->withInput(['success' => 'Product has been updated']);

	}




	public function destroy($id, Request $request)
	{

		//dd($id);

		$cart = $this->cartRepository->getCart(['cartProducts']);

		//dd($cart);

		//$product = $product = $cart->cartProducts->get($id);

		$product = $cart->cartProducts->keyBy('id')->get($id);

//		$product = $cart->cartProducts->filter(function($item) use ($id) {
//			return $item->id == $id;
//		})->first();


		//dd($product);

		$product->delete();

		//dd($product = $cart->cartProducts->get($id));

		//->delete()

		return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Product has been removed from your cart']);

	}
}
