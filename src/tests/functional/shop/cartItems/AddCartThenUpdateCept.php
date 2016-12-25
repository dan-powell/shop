<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart, then update quantity');

$product = $I->have(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);
$I->click('Add to Cart');
$I->seeCurrentRouteIs('shop.cart.show');
$I->see('Product added to cart', '.alert');

$I->submitForm('#update', ['quantity' => 5]);

$I->see('Product quantity has been updated', '.alert');

$I->seeInField('#update [name=quantity]','5');

?>