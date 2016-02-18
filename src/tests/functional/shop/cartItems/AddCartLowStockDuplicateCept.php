<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a duplicate product to cart that has low stock');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'quantity' => 6
]);

$I->seeCurrentRouteIs('shop.cart.index');

$I->see('Product added to cart', '.alert');

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'quantity' => 6
]);

$I->seeCurrentRouteIs('shop.product.show', $product->slug);

$I->dontSee('Product added to cart', '.alert');

$I->see('not enough product stock');

$I->seeFormHasErrors();
