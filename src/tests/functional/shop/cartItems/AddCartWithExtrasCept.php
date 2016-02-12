<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Add a product to cart that has extras');

// Create a Product and add some Extras
$product = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
for($i = 0; $i < 2; $i++) {
    $extras[] = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], 'inStock', 1);
}
$product->extras()->saveMany($extras);

// Create another product so we can try and force it's option on to the 'correct' product
$unrelatedProduct = $I->createModel(DanPowell\Shop\Models\Product::class, [], 'inStock', 1);
$unrelatedExtra = $I->makeModel(DanPowell\Shop\Models\Extra::class, [], 'inStock', 1);
$unrelatedProduct->extras()->save($unrelatedExtra);


// Go to the product page
$I->amOnRoute('shop.product.show', $product->slug);

// Select only the first Extra
$I->checkOption('extra[' . $extras[0]->id . ']');

$I->submitForm('#addToCart', [
    // include an unrelated extra
    'extra[' . $unrelatedExtra->id . ']' => 'on'
]);
$I->seeCurrentRouteIs('shop.cart.index');

$I->see('Product added to cart', '.alert');
$I->see($product->title, '.CartTable-product-title');

// Should see first Extra
$I->see($extras[0]->title, '.CartTable-item-extras');

// Should *not* see any other Extras
$I->dontSee($extras[1]->title, '.CartTable-item-extas');
$I->dontSee($unrelatedExtra->title, '.CartTable-item-extas');

?>