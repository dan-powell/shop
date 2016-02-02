<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

use Illuminate\Foundation\Validation\ValidatesRequests;

class CartItemController extends BaseController
{

	use ValidatesRequests;

	//protected $repository;
	protected $repository;
	protected $productPublicRepository;

	/**
	 * CartItemController constructor.
	 * @param CartRepository $CartRepository
	 * @param ProductPublicRepository $ProductPublicRepository
	 */
	public function __construct(CartItemRepository $CartItemRepository, ProductPublicRepository $ProductPublicRepository)
	{
		$this->repository = $CartItemRepository;
		$this->productPublicRepository = $ProductPublicRepository;
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request)
	{

		// Find product to be added
		$product = $this->productPublicRepository->getById($request->get('product_id'), ['extras.options', 'options']);

		if(!$product) {
			return redirect()->route('shop.product.show', $product->slug);
		}

		// Validate input
		$modelValidation = $this->repository->getRules($product);
		$this->validate($request, $modelValidation['rules'], $modelValidation['messages']);


		// Set the Product option values
		$submittedOptions = $request->get('option');
		$product->options->each(function ($option) use ($submittedOptions) {
			if (isset($submittedOptions[$option->id])) {
				$option->value = $submittedOptions[$option->id];
			}
		});

		// Set the Extras (filter out extras user has not selected)
		$submittedExtras = $request->get('extra');
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
		$quantityToCheck = $this->getProductQuantityInCart($product->id) + $request->get('quantity');


		// Check product stock
		if(!$product->checkStock($quantityToCheck)) {
			dd('too many!');
			return redirect()->route('shop.product.show', $product->slug);
		}

		// Check product extras stock
		$product->extras->each(function ($extra) use ($quantityToCheck, $product) {
			if(!$extra->checkStock($quantityToCheck)) {
				dd('too many Extras!');
				return redirect()->route('shop.product.show', $product->slug);
			}
		});


		$fill = [
			'cart_id' => $this->repository->getCartId(),
			'product_id' => $product->id,
			'options' => $product->options,
			'extras' => $product->extras
		];

		// Check if this item config is already saved & update quantity...
		$findItem = $this->repository->incrementQuantity($fill, $request->get('quantity'));

		// ...otherwise, if no matching items were found...
		if(!$findItem) {
			$fill['quantity'] = $request->get('quantity');
			$this->repository->create($fill);
		}

		// Take user to cart
		return redirect()->route('shop.cart.index');
	}


	/**
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function update($id, Request $request)
	{

		// Validate the request
		$this->validate($request, ['quantity' => 'required|integer|min:1|max:99']);

		// Find the item to update
		$item =  $this->repository->getById($id, ['product.extras']);

		// redirect if no product found
		if($item) {

			// Get the Extras (filter out extras user has not selected)
			$item->product->extras = $item->product->extras->filter(function ($extra) use ($item) {
				foreach($item->extras as $itemExtra) {
					if ($itemExtra['id'] == $extra->id) {
						return $extra;
					}
				}
			});

			// Calc the total quantity to check
			$quantityToCheck = ($this->getProductQuantityInCart($item->product->id) + $request->get('quantity')) - $item->quantity;

			// Check product stock
			if(!$this->checkProductStock($item->product, $quantityToCheck)) {
				dd('too many!');
				return redirect()->route('shop.cart.index');
			}

			// Check product extras stock
			if(!$this->checkProductExtrasStock($item->product, $quantityToCheck)) {
				dd('too many extras!');
				return redirect()->route('shop.cart.index');
			}

			// Find & update the item
			if($this->repository->update($id, $request->get('quantity'))){
				$message = ['success' => 'Product quantity has been updated'];
			} else {
				$message = ['warning' => 'Product quantity has not been updated'];
			}

		} else {
			$message = ['warning' => 'Product not found'];
		}

		return redirect()->route('shop.cart.index')->withInput($message);

	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function destroy($id)
	{
		$this->repository->delete($id);
		return redirect()->route('shop.cart.index', 301)->withInput(['warning' => 'Item has been removed from your cart']);
	}


	private function getProductQuantityInCart($product_id) {

		// Find all items of the same product, so we can calculate the total quantity in the cart
		$items = $this->repository->getCartItems()->where(
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
