<?php namespace DanPowell\Shop\Http\Controllers;


use Illuminate\Routing\Controller;

// Load up the models
use DanPowell\Shop\Models\Product;

use DanPowell\Shop\Repositories\ModelRepository;
use DanPowell\Shop\Repositories\ProductRepository;

class ProductController extends Controller
{

	private $productRepository;

    public function __construct(ProductRepository $ProductRepository)
    {
        $this->productRepository = $ProductRepository;
    }

    /**
     * Show list of products
     * @return View
     */
	public function index()
	{

    	$products = $this->productRepository->getAll();

		return view('shop::product.index')->with([
		    'products' => $products,
        ]);

	}


    /**
     * Show a product
     * @param $slug
     * @return RedirectResponse
     */
	public function show($slug)
	{

        if (is_numeric($slug)) {
            // Redirect to slug
			return $this->productRepository->redirectId($slug, 'shop.product.show');

        } else {
			$product = $this->productRepository->getBySlug($slug);

			// Set the default template if not provided
            /*
			if ($product->template == null || $product->template == 'default') {
				$template = 'shop::product.show';
			} else {
				$template = 'shop::templates.' . $product->template;
			}
            */

			// Return view with projects
			return view('shop::product.show')->with(['product' => $product]);

        }
	}

}
