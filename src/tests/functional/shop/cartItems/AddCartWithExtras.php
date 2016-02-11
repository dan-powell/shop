<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has extras');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$extras = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], null, 2);

$product->extras()->save($extras);

$I->amOnPage(route('shop.product.show', $product->slug));

$I->checkOption($extras[0]->title);

$I->submitForm('#addToCart', []);

$I->see('Product added to cart');
$I->see($product->title);
$I->see($extras[0]->title);
$I->dontSee($extras[1]->title);

?>