<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has extras with options');

// Create the models
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$extras = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], null, 2);
$product->extras()->save($extras);
foreach($extras as $extra){
    $options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
    $options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
    $options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);
    $extra->options()->save($options);
}

$I->amOnPage(route('shop.product.show', $product->slug));

// Select the option values
$option_values = [];
foreach($extras as $extra){
    $I->checkOption($extra->title);
    foreach($extra->options as $option){
        if ($option->type == 'radio' || $option->type == 'select') {
            $option_values[$option->id] = array_rand($option->config);
            $I->selectOption($option->title, $option_values[$option->id]);
        } else {
            $option_values[$option->id] = array_rand($option->config);
            $I->fillField($option->title, 'whatever');
        }
    }
}

$I->submitForm('#addToCart', []);

$I->see('Product added to cart');
$I->see($product->title);

foreach($extras as $extra){

    $I->see($extra->title);

    foreach($extra->options as $option){
        // The option title
        $I->see($option->title);
        // The option value
        $I->see($option_values[$option->id]);
    }
}

?>