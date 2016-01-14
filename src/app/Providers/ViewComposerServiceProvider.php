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
        $this->app->view->composer('shop::partials.list','DanPowell\Shop\Http\ViewComposers\ProductListComposer');
    }

}