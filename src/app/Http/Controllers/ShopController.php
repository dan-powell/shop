<?php namespace DanPowell\Shop\Http\Controllers;


use Illuminate\Routing\Controller;

// Load up the models
use DanPowell\Shop\Models\Product;

use DanPowell\Shop\Repositories\ModelRepository;

class ShopController extends Controller
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
	public function home()
	{


        // Return view
		return view('shop::home');

//		->with([
//		    'featured' => $featured,
//		    //'tags' =>  $tags
//        ]);

	}

}
