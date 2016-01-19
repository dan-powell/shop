<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Repositories\ProductRepository;

class FeaturedProductComposer {

    private $productRepository;

    /**
     * Create a new profile composer.
     *
     * @param  UserRepository  $users
     * @return void
     */
    public function __construct(ProductRepository $ProductRepository)
    {
        $this->productRepository = $ProductRepository;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $featured = $this->productRepository->getFeatured();

        $view->with('featured', $featured);

    }

}

