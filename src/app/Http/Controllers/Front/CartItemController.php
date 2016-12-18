<?php namespace DanPowell\Shop\Http\Controllers\Front;

// Repositories
use DanPowell\Shop\Repositories\CartRepository;
use DanPowell\Shop\Repositories\CartItemRepository;
use DanPowell\Shop\Repositories\ProductPublicRepository;

// Requests
use DanPowell\Shop\Http\Requests\CartItemStoreRequest;
use DanPowell\Shop\Http\Requests\CartItemUpdateRequest;
use Illuminate\Foundation\Validation\ValidatesRequests;


class CartItemController extends BaseController
{

	use ValidatesRequests;

	protected $repository;
	protected $productPublicRepository;
	protected $cartRepository;

	/**
	 * CartItemController constructor.
	 * @param CartItemRepository $CartItemRepository
	 * @param ProductPublicRepository $ProductPublicRepository
	 */
	public function __construct(CartRepository $CartRepository, CartItemRepository $CartItemRepository, ProductPublicRepository $ProductPublicRepository)
	{
		$this->repository = $CartItemRepository;
		$this->cartRepository = $CartRepository;
		$this->productPublicRepository = $ProductPublicRepository;
	}


	/**
	 * Add/update a cartItem to the cart
	 * @param CartItemStoreRequest $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
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
			'cart_id' => $this->cartRepository->getCartId(),
			'product_id' => $product->id,
			'config' => json_encode($config)
		])->increment('quantity', $request->get('quantity'));

		// If we didn't find existing item, create a new one
		if(!$findItem) {

			$item->fill([
				'cart_id' => $this->cartRepository->getCartId(),
				'product_id' => $product->id,
				'config' => $config,
				'quantity' => $request->get('quantity'),
			]);

			$item->save();

			$item->options()->attach($options);

			$item->extras()->attach($extras);

            \Notification::success('Product added to cart');
		} else {
            \Notification::success('Product quantity updated');
		}

		// Take the user to the cart page
		return redirect()->route('shop.cart.show');
	}


	/**
	 * @param $id
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(CartItemUpdateRequest $request, $id)
	{

		// Find & update the item
		if($this->repository->update($id, ['quantity' => $request->get('quantity')])){
            \Notification::success('Product quantity has been updated');
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
        \Notification::info('Product removed');
		return redirect()->route('shop.cart.show', 301);
	}


}
