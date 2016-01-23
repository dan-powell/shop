<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Repositories\ProductRepository;

use DanPowell\Shop\Traits\ImageTrait;

class FeaturedProductComposer {

    use ImageTrait;

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

        $this->getImageTypes($featured);

        $view->with('featured', $featured);

    }

}

