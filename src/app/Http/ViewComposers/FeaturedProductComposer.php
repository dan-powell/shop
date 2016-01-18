<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Models\Product;

class FeaturedProductComposer {

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

        $featured = Product::where('featured', '=', '1')->where('published', '!=', '0')->with(['images'])->get();
        $view->with('featured', $featured);

    }

}

