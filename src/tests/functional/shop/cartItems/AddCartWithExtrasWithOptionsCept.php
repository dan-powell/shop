<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has extras with options');

// Create the models
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);

// Extra 1 - This extra has a few options and will be selected
$extra1 = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], 'inStock', 1);
$extra1 = $product->extras()->save($extra1);

$options1[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options1[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options1[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'text', 1);
$options1 = $extra1->options()->saveMany($options1);

// Extra 2 - This extra will not be selected
$extra2 = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], 'inStock', 1);
$extra2 = $product->extras()->save($extra2);

$options2[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'radio', 1);
$options2[] = $I->makeModel(DanPowell\Shop\Models\Option::class, [], 'select', 1);
$options2 = $extra2->options()->saveMany($options2);

$I->amOnRoute('shop.product.show', $product->slug);

// Select the extra 1
$I->checkOption('extra['.$extra1->id.']');

// Select some options to make sure they appear in the cart
$option_values = [];
foreach(array_merge($options1, $options2) as $option) {
    if($option->type == 'radio' || $option->type == 'select') {
        $option_values[$option->id] = $option->config[array_rand($option->config)];
        $I->selectOption('option[' . $option->id . ']', $option_values[$option->id]);
    } else {
        $option_values[$option->id] = "Testing";
        $I->fillField('option[' . $option->id . ']', "Testing");
    }
}

// Submit the form
$I->submitForm('#addToCart', []);
$I->seeCurrentRouteIs('shop.cart.index');
$I->see('Product added to cart', '.alert');
$I->see($product->title, '.CartTable-product-title');

// We should see extra 1 in the cart along with it's options
$I->see($extra1->title, '.CartTable-item-extras');
foreach($options1 as $option) {
    $I->see($option->title, '.CartTable-item-options');
    // option values should match up to those we selected
    $I->see($option_values[$option->id], '.CartTable-item-options');
}

// We should * NOT * see extra 2 in the cart or any of it's options & values
$I->dontSee($extra2->title, '.CartTable-item-extras');
foreach($options2 as $option) {
    $I->dontSee($option->title, '.CartTable-item-options');
    $I->dontSee($option_values[$option->id], '.CartTable-item-options');
}

?>