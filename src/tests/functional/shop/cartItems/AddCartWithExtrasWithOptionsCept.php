<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has extras with options');

// Create the models
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

$extra = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], null, 1);

$extra = $product->extras()->save($extra);

$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);

$options = $extra->options()->saveMany($options);


$I->amOnRoute('shop.product.show', $product->slug);

// Select the option values

$I->checkOption('extra['.$extra->id.']');

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
$I->see('Product added to cart');
$I->see($product->title);

$I->see($extra->title);


    foreach($options as $option) {
        // The option title
        $I->see($option->title);
        // The option value
        $I->see($option_values[$option->id]);
    }

?>