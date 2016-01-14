<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Models\Product;

class ProductListComposer {

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        //$projects = Project::where('featured', '=', '1')->orderBy('created_at', 'DESC')->take(3)->get();
        //$view->with('projects', $projects);

    }

}

