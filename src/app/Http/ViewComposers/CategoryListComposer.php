<?php namespace DanPowell\Shop\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DanPowell\Shop\Repositories\CategoryPublicRepository;

class CategoryListComposer {

    private $categoryRepository;

    public function __construct(CategoryPublicRepository $CategoryPublicRepository)
    {
        $this->repository = $CategoryPublicRepository;
    }


    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {

        $items = $this->repository->getAll()->toHierarchy();
        $view->with('categories', $items);

    }

}

