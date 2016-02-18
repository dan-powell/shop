<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has bad extras');

// Create the models
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

// Extra 1 - This extra has a few options and will be selected
$extra1 = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], 'inStock', 1);
$extra1 = $product->extras()->save($extra1);

$option1 = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);
$option1 = $extra1->options()->save($option1);


$I->amOnRoute('shop.product.show', $product->slug);

// Select the extra 1, but DON'T fill out the option value
$I->checkOption('extra['.$extra1->id.']');

$I->submitForm('#addToCart', []);

$I->dontSee('Product added to cart', '.alert');
$I->seeCurrentRouteIs('shop.product.show');
$I->seeFormHasErrors();

?>