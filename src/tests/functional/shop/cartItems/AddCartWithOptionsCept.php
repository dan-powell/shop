<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has options');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);

$product->options()->saveMany($options);

$I->amOnRoute('shop.product.show', $product->slug);

$option_values = [];
foreach($options as $option) {
    if($option->type == 'radio' || $option->type == 'select') {
        $option_values[$option->id] = $option->config[array_rand($option->config)];
        $I->selectOption('option[' . $option->id . ']', $option_values[$option->id]);
    } else {
        $option_values[$option->id] = "Testing";
        $I->fillField('option[' . $option->id . ']', "Testing");
    }
}

$I->submitForm('#addToCart', []);
$I->seeCurrentRouteIs('shop.cart.index');
$I->see('Product added to cart', '.alert');
$I->see($product->title, '.CartTable-product-title');

foreach($options as $option) {
    $I->see($option->title, '.CartTable-item-options');
    if($option->type == 'radio' || $option->type == 'select') {
        $I->see($option_values[$option->id], '.CartTable-item-options');
    } else {
        $I->see('Testing', '.CartTable-item-options');
    }
}

?>