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

		// Validate request
		$validation = $this->repository->getValidationRules($product);
		$this->validate($request, $validation['rules'], $validation['messages']);


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
		$quantityToCheck = $this->repository->getTotalProductQuantityInCart($product->id) + $request->get('quantity');


		// Check product stock
		if(!$product->checkStock($quantityToCheck)) {
			session()->flash('alert-warning', 'Not enough product stock available.');
			return redirect()->route('shop.product.show', $product->slug);
		}

		// Check product extras stock
		$product->extras->each(function ($extra) use ($quantityToCheck, $product) {
			if(!$extra->checkStock($quantityToCheck)) {
				session()->flash('alert-warning', 'Not enough stock available to add this extra.');
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
		session()->flash('alert-success', 'Product added to cart');
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
			$quantityToCheck = ($this->repository->getTotalProductQuantityInCart($item->product->id) + $request->get('quantity')) - $item->quantity;

			// Check product stock
			if(!$item->product->checkStock($quantityToCheck)) {
				session()->flash('alert-warning', 'Not enough product stock available.');
				return redirect()->back();
			}

			// Check product extras stock
			$item->product->extras->each(function ($extra) use ($quantityToCheck) {
				if(!$extra->checkStock($quantityToCheck)) {
					session()->flash('alert-warning', 'Not enough stock available to add this extra.');
					return redirect()->back();
				}
			});

			// Find & update the item
			if($this->repository->update($id, $request->get('quantity'))){
				session()->flash('alert-success', 'Product quantity has been updated');
			}

		} else {
			session()->flash('alert-warning', 'Product not found');
		}

		return redirect()->route('shop.cart.index');

	}

	/**
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function destroy($id)
	{
		$this->repository->delete($id);
		session()->flash('alert-danger', 'Product removed');
		return redirect()->route('shop.cart.index', 301);
	}




}
