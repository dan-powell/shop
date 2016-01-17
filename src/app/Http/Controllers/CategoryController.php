<?php namespace DanPowell\Shop\Http\Controllers;


use Illuminate\Routing\Controller;

// Load up the models
use DanPowell\Shop\Models\Category;

use DanPowell\Shop\Repositories\ModelRepository;

class CategoryController extends Controller
{

    public function __construct(ModelRepository $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }

    /**
    *   Return a view listing all of the projects
	*
	*   @return View - returns created page, or throws a 404 if slug is invalid or can't find a matching record
	*/
	public function index()
	{

    	// Get all the projects
		$items = $this->modelRepository->getAll(new Category, ['products', 'images', 'categories']);
		
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

        // check to see if id is valid then determine if it is an id or a slug
        if (is_numeric($slug)) {
			return $this->modelRepository->redirectId(new Category, $slug, 'category.show');
        }
        else {
			$item = $this->modelRepository->getBySlug(new Category, $slug, ['products', 'images', 'categories']);

			// Set the default template if not provided
			if ($item->template == null || $item->template == 'default') {
				$template = 'shop::category.show';
			} else {
				$template = 'shop::templates.' . $item->template;
			}

			// Return view with projects
			return view($template)->with(['category' => $item]);

        }
	}


    /**
    *   Return a view showing one of the pages
	*
	* @param String $slug - if numeric will be treated as an id, otherwise will search for matching slug
	* @param String $pageSlug - if numeric will be treated as an id, otherwise will search for matching slug
	* @return View - returns created page, or throws a 404 if slug is invalid or can't find a matching record
	*/
	/*
	public function page($slug, $pageSlug)
	{
    	// Build query to find relevent Project
        $query = Project::where('slug', '=', $slug)->with('pages');
        $project = $query->first();

        // Check if a project was found
        if ($project == null) {
            return abort('404', 'Invalid project slug');
        } else {

            // Filter related pages and return the one with the correct slug
            $filteredPages = $project->pages->filter(function($page) use ($pageSlug)
            {
                if(isset($page->slug) && $page->slug == $pageSlug) {
            	    return $page;
            	}
            });
            $page = $filteredPages->first();

            // Check if a page was found
            if ($page != null) {

                if ($page->template == null || $page->template == 'default') {
    		        $template = 'portfolio::page';
    		    } else {
    			    $template = 'portfolio::pages.' . $page->template;
    			}

                // Return view with projects
    			return view($template)->with(['page' => $page, 'project' => $project]);

    	   	} else {
    		   	// No project found, throw a 404.
                return abort('404', 'Invalid page slug');
            }
        }

	}
*/


}
