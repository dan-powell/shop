<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'published', 1);

$I->amOnRoute('shop.product.show', $product->slug);
$I->click('Add to Cart');
$I->seeCurrentRouteIs('shop.cart.index');
$I->see('Product added to cart');
$I->see($product->title);

?>