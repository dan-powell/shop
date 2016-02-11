<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has options');

$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$options = $I->makeModel(DanPowell\Shop\Models\Option::class, [], null, 3);

$product->options()->save($options);

$I->amOnPage(route('shop.product.show', $product->slug));

$option_values = [];
foreach($options as $option) {
    if($option->type == 'radio' || $option->type == 'select') {
        $option_values[$option->title] = array_rand($option->config);
        $I->selectOption($option->title, $option_values[$option->title]);
    }
}

$I->submitForm('#addToCart', []);

$I->see('Product added to cart');
$I->see($product->title);

foreach($options as $option) {
    $I->see($option->title);
    if($option->type == 'radio' || $option->type == 'select') {
        $I->see($option_values[$option->title]);
    }
}

?>