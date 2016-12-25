<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has no stock');

$product = $I->have(DanPowell\Shop\Models\Product::class, [], 'outOfStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);

$I->see('Out of Stock');

$I->submitForm('#addToCart', []);

$I->dontSee('Product added to cart');

$I->see('Out of Stock');

$I->seeFormHasErrors();