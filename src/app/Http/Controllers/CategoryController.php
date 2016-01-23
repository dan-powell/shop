<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Routing\Controller;
use DanPowell\Shop\Repositories\CategoryPublicRepository;

use DanPowell\Shop\Traits\ImageTrait;
use DanPowell\Shop\Traits\ControllerTrait;

class CategoryController extends Controller
{

	use ImageTrait;
	use ControllerTrait;

	private $repository;

	public function __construct(CategoryPublicRepository $CategoryPublicRepository)
	{
		$this->repository = $CategoryPublicRepository;
	}

	/**
	 * Show list of items
	 * @return View
	 */
	public function index()
	{

		$categories = $this->repository->getAll(['images'])->toHierarchy();

		$this->addImageTypes($categories);

		return view('shop::category.index')->with([
			'categories' => $categories,
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
			return $this->redirectById($slug, 'shop.category.show');

		} else {

			$item = $this->findItemOrFail($slug, ['images', 'products.images']);

			// Group images on product
			$this->addImageTypes($item);

			// Group images on related products
			$item->products->each(function ($m) {
				$this->addImageTypes($m);
			});


			$item->categories = $item->children()->where('published', '!=', '0')->with(['images'])->get();

			$item->categories->each(function ($m) {
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
			return view('shop::category.show')->with(['category' => $item]);
		}

	}

}
