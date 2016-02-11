<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has bad options');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$option = $I->makeModel(DanPowell\Shop\Models\Option::class, [], null, 3);

$product->options()->save($option);

$I->amOnPage(route('shop.product.show', $product->slug));

$I->submitForm('#addToCart', [
    'option[32]' => '23',
    'option[butts]' => 'gdfgdgdfgfd',
    'option[lush]' => '94'
]);

$I->dontSee('Product added to cart');

$I->seeFormHasErrors();

?>