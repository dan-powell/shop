<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Models\Category;

class CategoryListComposer {

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

        $items = Category::where('published', '!=', '0')->get()->toHierarchy();
        $view->with('categories', $items);

    }

}

