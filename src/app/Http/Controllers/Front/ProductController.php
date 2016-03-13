<?php namespace DanPowell\Shop\Http\Controllers\Front;

use DanPowell\Shop\Repositories\ProductPublicRepository;
use DanPowell\Shop\Repositories\ProductRepository;

use DanPowell\Shop\Traits\ImageTrait;

class ProductController extends BaseController
{
	use ImageTrait;

    protected $repository;

    public function __construct(ProductPublicRepository $ProductPublicRepository)
    {
        $this->repository = $ProductPublicRepository;
    }

    /**
     * Show list of items
     * @return View
     */
	public function index()
	{

    	$products = $this->repository->getAll($with = ['images']);

		$this->addImageTypes($products);

		return view('shop::front.product.index.productIndex')->with([
		    'products' => $products,
        ]);

	}


    /**
     * Show a single item
     * @param $slug
     * @return $this|\Illuminate\Http\RedirectResponse
     */
	public function show($slug)
	{

		if (is_numeric($slug)) {

			// Redirect to slug
			return $this->redirectById($slug, 'shop.product.show');

		} else {

			$product = $this->repository->getProductBySlug($slug);

			if($product) {

				// Set the default template if not provided
				/*
                if ($product->template == null || $product->template == 'default') {
                    $template = 'shop::product.show';
                } else {
                    $template = 'shop::templates.' . $product->template;
                }
                */

				// Return view with projects
				return view('shop::front.product.show.productShow')->with(['product' => $product]);
			} else {
				abort('404', 'Product not found');
			}

		}

	}

}
