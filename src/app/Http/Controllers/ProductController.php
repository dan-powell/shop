<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Routing\Controller;
use DanPowell\Shop\Repositories\ProductPublicRepository;

use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\ControllerTrait;

class ProductController extends Controller
{

	use ImageTrait;
	use ControllerTrait;

	private $repository;

    public function __construct(ProductPublicRepository $ProductPublicRepository)
    {
        $this->repository = $ProductPublicRepository;
    }

    /**
     * Show list of products
     * @return View
     */
	public function index()
	{

    	$products = $this->repository->getAll();

		$this->addImageTypes($products);

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
			return $this->redirectById($slug, 'shop.product.show');

		} else {

			$product = $this->findItemOrFail($slug);

			$this->addImageTypes($product);

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
