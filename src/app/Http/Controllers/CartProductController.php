<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

use DanPowell\Shop\Models\Cart;
use DanPowell\Shop\Models\CartProduct;
use DanPowell\Shop\Models\CartOption;
use DanPowell\Shop\Models\CartPersonalisation;

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

		$id = $request->get('product_id');

		// Find the product to be added
		$product = $this->productPublicRepository->getById($id);


		if($request->get('quantity') != null){
			$loop = $request->get('quantity');
		} else {
			$loop = 1;
		}


		for($i=0; $i < $loop; $i++){

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

			if ($option_fields != null && count($option_fields)) {

				foreach ($option_fields as $option) {


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

			if ($personalisation_fields != null && count($personalisation_fields)) {

				foreach ($personalisation_fields as $key => $personalisation_field) {


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
		}

		return redirect()->route('shop.cart.index', 301)->withInput(['success' => 'Product has been added to your cart']);


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

		$product = $cart->cartProducts->filter(function($item) use ($id) {
			return $item->id == $id;
		})->first();


		//dd($product);

		$product->delete();

		//dd($product = $cart->cartProducts->get($id));

		//->delete()

		return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Product has been removed from your cart']);

	}
}
