<?php namespace DanPowell\Shop\Http\Controllers\Front;

use Illuminate\Http\Request;

use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

// Requests
use DanPowell\Shop\Http\Requests\CartItemStoreRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;




class CartItemController extends BaseController
{

	use ValidatesRequests;

	protected $repository;
	protected $productPublicRepository;


	public function __construct(CartItemRepository $CartItemRepository, ProductPublicRepository $ProductPublicRepository)
	{
		$this->repository = $CartItemRepository;
		$this->productPublicRepository = $ProductPublicRepository;
	}


	public function store(CartItemStoreRequest $request)
	{

		// We've already queried the product to validate the request, so let's use that
		$product = $request->getProduct();

		// Gather the Product Options and their values
		$options = [];
		foreach ($product->options as $option) {
			if($request->get('option')[$option->id]) {
				$options[$option->id] = ['value' => $request->get('option')[$option->id]];
			}
		}

		// Gather the Product Extras
		$extras = [];
		foreach ($product->extras as $extra) {
			if($request->get('extra')[$extra->id]) {
				$extras[$extra->id] = ['value' => $request->get('extra')[$extra->id]];
			}
			// Gather the Extra Options and their values
			foreach ($extra->options as $option) {
				if($request->get('option')[$option->id]) {
					$options[$option->id] = ['value' => $request->get('option')[$option->id]];
				}
			}
		}

		// Start a new query
		$item = $this->repository->makeModel();

		// Serialise the options and extras
		$config = ['options' => $options, 'extras' => $extras];

		// Find if item already exists in cart and update config if so
		$findItem = $item->where([
			'cart_id' => $this->repository->getVerifiedCartId(),
			'product_id' => $product->id,
			'config' => json_encode($config)
		])->increment('quantity', $request->get('quantity'));

		// If we did'nt find existing item, create a new one
		if(!$findItem) {

			$item->fill([
				'cart_id' => $this->repository->getVerifiedCartId(),
				'product_id' => $product->id,
				'config' => $config,
				'quantity' => $request->get('quantity'),
			]);

			$item->save();

			$item->options()->attach($options);

			$item->extras()->attach($extras);

			session()->flash('alert-success', 'Product added to cart');
		} else {
			session()->flash('alert-success', 'Product quantity updated');
		}

		// Take the user to the cart page
		return redirect()->route('shop.cart.show');
	}


	/**
	 * @param $id
	 * @param Request $request
	 * @return $this
	 */
	public function update($id, Request $request)
	{

		// Find the item to update
		$item = $this->repository->getById($id, ['product']);
		if(!$item) {
			session()->flash('alert-warning', 'Cart item not found');
			return redirect()->route('shop.cart.index');
		}

		if ($item->product->allow_negative_stock) {
			$max = config('shop.maxProductCartQuantity') - $this->repository->getTotalProductQuantityInCart($item->product->id);
		} else {
			$max = $item->product->stock - $this->repository->getTotalProductQuantityInCart($item->product->id);
		}

		// Validate the request
		$this->validate($request, [
			'quantity' => 'required|integer|min:1|max:' . $max
		]);



		// Find & update the item
		if($this->repository->update($id, $request->get('quantity'))){
			session()->flash('alert-success', 'Product quantity has been updated');
		}


		return redirect()->route('shop.cart.show');

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
		return redirect()->route('shop.cart.show', 301);
	}


}
