<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a duplicate product to cart');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'quantity' => 2
]);

$I->seeCurrentRouteIs('shop.cart.show');

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'quantity' => 2
]);

$I->seeCurrentRouteIs('shop.cart.show');

$I->see('x4');


