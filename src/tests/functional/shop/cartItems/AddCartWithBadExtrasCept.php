<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has bad extras');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$extras = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], null, 2);

$product->extras()->save($extras);

$I->amOnPage(route('shop.product.show', $product->slug));

$I->submitForm('#addToCart', [
    'extra[32]' => '23',
    'extra[butts]' => 'gdfgdgdfgfd'
]);

$I->dontSee('Product added to cart');

$I->seeFormHasErrors();

?>