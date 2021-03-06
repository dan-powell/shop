<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['prefix' => config('shop.routes.front.prefix')], function() {


    Route::get(config('shop.routes.front.product.index'),
        ['as' => 'shop.product.index', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\ProductController@index']);

    Route::get(config('shop.routes.front.product.show'),
        ['as' => 'shop.product.show', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\ProductController@show']);

    Route::get(config('shop.routes.front.category.index'),
        ['as' => 'shop.category.index', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\CategoryController@index']);

    Route::get(config('shop.routes.front.category.show'),
        ['as' => 'shop.category.show', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\CategoryController@show']);

    Route::get(config('shop.routes.front.cart.show'),
        ['as' => 'shop.cart.show', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\CartController@show']);


    Route::delete(config('shop.routes.front.cart.clearproduct'),
        [
            'as' => 'shop.cart.clearproduct',
            'uses' => 'DanPowell\Shop\Http\Controllers\Front\CartController@clearProduct'
        ]
    );

    Route::delete(config('shop.routes.front.cart.clear'),
        [
            'as' => 'shop.cart.clear',
            'uses' => 'DanPowell\Shop\Http\Controllers\Front\CartController@clear'
        ]
    );

    Route::resource(
        config('shop.routes.front.cart.item'),
        'DanPowell\Shop\Http\Controllers\Front\CartItemController',
        [
            //'as' => 'shop.cart',
            'except' => ['create', 'show', 'edit', 'index'],
            'names' => [
                //'index' => 'shop.cart.index',
                'store' => 'shop.cart.item.store',
                'destroy' => 'shop.cart.item.delete',
                'update' => 'shop.cart.item.update'
            ],
        ]
    );


    Route::get(config('shop.routes.front.order.create'),
        ['as' => 'shop.order.create', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\OrderController@create']);

    Route::post(config('shop.routes.front.order.store'),
        ['as' => 'shop.order.store', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\OrderController@store']);

    Route::post(config('shop.routes.front.order.confirm'),
        ['as' => 'shop.order.confirm', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\OrderController@confirm']);

    Route::get(config('shop.routes.front.order.cancel'),
        ['as' => 'shop.order.cancel', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\OrderController@cancel']);

    Route::get(config('shop.routes.front.order.show'),
        ['as' => 'shop.order.show', 'uses' => 'DanPowell\Shop\Http\Controllers\Front\OrderController@show']);



});









/*

Route::get(config('shop.routes.front.showPage'), ['as' => 'projects.page', 'uses' => 'DanPowell\Shop\Http\Controllers\ProjectController@page']);


// Admin area
Route::group(['prefix' => config('portfolio.routes.admin.prefix'), 'middleware' => ['auth']], function()
{

    Route::get(config('portfolio.routes.admin.home'), ['as' => 'admin', function() {
        return view('portfolio::admin.base');
    }]);

});
*/


/*
// RESTful API
Route::group(['prefix' => config('portfolio.routes.api.prefix')], function()
{

    // Projects
    Route::resource(
        config('portfolio.routes.api.project'),
        'DanPowell\Shop\Http\Controllers\Api\ProjectController',
        ['except' => ['create', 'edit']]
    );

    // Project Sections
    Route::resource(
        config('portfolio.routes.api.project') . '.' . config('portfolio.routes.api.section'),
        'DanPowell\Shop\Http\Controllers\Api\ProjectSectionController',
        ['except' => ['create', 'edit', 'update', 'destroy']]
    );

    // Sections
    Route::resource(
        config('portfolio.routes.api.section'),
        'DanPowell\Shop\Http\Controllers\Api\SectionController',
        ['except' => ['create', 'edit']]
    );

    // Tags
    Route::get(config('portfolio.routes.api.tagSearch'), ['as' => 'api.tag.search', 'uses' => 'DanPowell\Shop\Http\Controllers\Api\TagController@search']);
    Route::resource(
        config('portfolio.routes.api.tag'),
        'DanPowell\Shop\Http\Controllers\Api\TagController',
        ['except' => ['create', 'edit']]
    );

    // Assets
    //Route::resource('assets', 'DanPowell\Shop\Http\Controllers\Api\AssetController', ['except' => ['create', 'edit']]);
	Route::get('assets', ['as' => 'assets.index', 'uses' => 'DanPowell\Shop\Http\Controllers\Api\AssetController@index']);
	Route::post('assets', ['as' => 'assets.create', 'uses' => 'DanPowell\Shop\Http\Controllers\Api\AssetController@store']);
	Route::put('assets', ['as' => 'assets.update', 'uses' => 'DanPowell\Shop\Http\Controllers\Api\AssetController@update']);
	Route::delete('assets', ['as' => 'assets.delete', 'uses' => 'DanPowell\Shop\Http\Controllers\Api\AssetController@destroy']);

    // Project Pages
    Route::resource(
        config('portfolio.routes.api.project') . '.' . config('portfolio.routes.api.page'),
        'DanPowell\Shop\Http\Controllers\Api\ProjectPageController',
        ['except' => ['create', 'edit', 'update', 'destroy']]
    );

    // Pages
    Route::resource(
        config('portfolio.routes.api.page'),
        'DanPowell\Shop\Http\Controllers\Api\PageController',
        ['except' => ['create', 'post', 'edit']]
    );

    // Project Sections
    Route::resource(
        config('portfolio.routes.api.page') . '.' . config('portfolio.routes.api.section'),
        'DanPowell\Shop\Http\Controllers\Api\PageSectionController',
        ['except' => ['create', 'edit', 'update', 'destroy']]
    );

});
*/