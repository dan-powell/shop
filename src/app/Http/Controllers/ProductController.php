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
     * Show list of items
     * @return View
     */
	public function index()
	{

    	$products = $this->repository->getAll($with = ['images']);

		$this->addImageTypes($products);

		return view('shop::product.index')->with([
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

			$product = $this->findItemOrFail($slug, ['images', 'related.images', 'optionGroups', 'personalisations']);

			// Group images on product
			$this->addImageTypes($product);

			// Group images on related products
			$product->related->each(function ($m) {
				$this->addImageTypes($m);
			});


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
