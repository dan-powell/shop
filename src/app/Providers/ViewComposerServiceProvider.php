<?php namespace DanPowell\Shop\Providers;

use View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider {

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->view->composer(
            'shop::front.category.list.categoryList',
            'DanPowell\Shop\Http\ViewComposers\CategoryListComposer'
        );

        $this->app->view->composer(
            'shop::front.product.list.productListFeatured',
            'DanPowell\Shop\Http\ViewComposers\FeaturedProductComposer'
        );
    }

}