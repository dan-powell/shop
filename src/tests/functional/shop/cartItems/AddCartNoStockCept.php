<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has no stock');

//$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'outOfStock', 1);
//
//$I->amOnPage(route('shop.product.show', $product->slug));
//
//$I->see('Sorry, Out of Stock');
//
//$I->submitForm('#addToCart', []);
//
//$I->dontSee('Product added to cart');
//
//$I->see('Out of Stock');
//
//$I->seeFormHasErrors();

?>