<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has no stock but allows negative stock levels');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'outOfStockAllowNegative', 1);

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', []);
$I->seeCurrentRouteIs('shop.cart.show');
$I->see('Product added to cart', '.alert');
$I->see($product->title);

?>