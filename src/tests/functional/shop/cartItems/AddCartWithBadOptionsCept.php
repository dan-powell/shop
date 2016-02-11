<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has bad options');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);

$product->options()->saveMany($options);

$I->amOnRoute('shop.product.show', $product->slug);

$I->submitForm('#addToCart', [
    'option[' . $options[0]->id . ']' => '23',
    'option[' . $options[1]->id . ']' => 'rewe',
    'option[' . $options[2]->id . ']' => 'Testing',
]);

$I->dontSee('Product added to cart');
$I->seeCurrentRouteIs('shop.product.show');
$I->seeFormHasErrors();

?>