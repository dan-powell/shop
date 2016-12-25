<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart, then update with a bad quantity value');

$product = $I->have(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);
$I->click('Add to Cart');
$I->seeCurrentRouteIs('shop.cart.show');
$I->see('Product added to cart', '.alert');

$I->submitForm('#update', ['quantity' => $product->stock + 1]);

$I->see('There is not enough product stock available', '.alert');

$I->dontSee('Product quantity has been updated', '.alert');



?>