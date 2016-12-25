<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has low stock');

$product = $I->have(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'quantity' => 15
]);

$I->dontSee('Product added to cart');

$I->see('not enough product stock');

$I->seeFormHasErrors();