<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Repositories\CategoryRepository;

class CategoryListComposer {

    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $items = $this->categoryRepository->getAllWithoutImages();
        $view->with('categories', $items);

    }

}

