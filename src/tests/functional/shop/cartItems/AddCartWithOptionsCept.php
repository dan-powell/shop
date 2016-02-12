<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has options');

// Make models
// Create a product with some options
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);
$product->options()->saveMany($options);

// Create another product so we can try and force it's option on to the 'correct' product
$unrelatedProduct = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$unrelatedOption = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$unrelatedProduct->options()->save($unrelatedOption);


$I->amOnRoute('shop.product.show', $product->slug);

// Randomly choose the option values
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

// Submit the form
$I->submitForm('#addToCart', [
    // include an unrelated option
    'option[' . $unrelatedOption->id . ']' => $unrelatedOption->config[0]
]);

$I->seeCurrentRouteIs('shop.cart.index');

// Check that we see the product
$I->see('Product added to cart', '.alert');
$I->see($product->title, '.CartTable-product-title');

// Check that the selected options have been sent through
foreach($options as $option) {
    $I->see($option->title, '.CartTable-item-options');
    $I->see($option_values[$option->id], '.CartTable-item-options');
}

// Check that the unrelated option we forced through has *not* appeared
$I->dontSee($unrelatedOption->title, '.CartTable-item-options');
$I->dontSee($unrelatedOption->config[0], '.CartTable-item-options');

?>