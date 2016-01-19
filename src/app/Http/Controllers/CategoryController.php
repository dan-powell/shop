<?php namespace DanPowell\Shop\Http\Controllers;

use Illuminate\Routing\Controller;
use DanPowell\Shop\Repositories\CategoryRepository;


class CategoryController extends Controller
{

	private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }



	/**
	 * Show list of categories
	 * @return View
	 */
	public function index()
	{

		$items = $this->categoryRepository->getAll();

		// Return view along with projects and filtered tags
		return view('shop::category.index')->with([
			'categories' => $items,
		]);


	}





	/**
    *   Return a view showing one of the projects
	*
	* @param String $slug - if numeric will be treated as an id, otherwise will search for matching slug
	* @return View - returns created page, or throws a 404 if slug is invalid or can't find a matching record
	*/
	public function show($slug)
	{


		if (is_numeric($slug)) {
			// Redirect to slug
			return $this->categoryRepository->redirectId($slug, 'shop.category.show');

		} else {
			$category = $this->categoryRepository->getBySlug($slug);

			// Set the default template if not provided
			/*
            if ($product->template == null || $product->template == 'default') {
                $template = 'shop::product.show';
            } else {
                $template = 'shop::templates.' . $product->template;
            }
            */

			// Return view models
			return view('shop::category.show')->with([
				'category' => $category
			]);

		}

	}

}
