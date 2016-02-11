<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has no stock but allows negative stock levels');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'outOfStockAllowNegative', 1);
$option = $I->makeModel(DanPowell\Shop\Models\Option::class, [], null, 1);

$product->options()->save($option);

$I->amOnPage(route('shop.product.show', $product->slug));

$I->submitForm('#addToCart', []);

$I->see('Product added to cart');
$I->see($product->title);

?>