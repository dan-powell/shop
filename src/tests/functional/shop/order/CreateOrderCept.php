<?php

$I = new FunctionalTester($scenario);

$I->wantTo('Create an order');

// Add a product to the cart
$product = $I->have(DanPowell\Shop\Models\Product::class, [], 'published', 1);
$I->amOnRoute('shop.product.show', $product->slug);
$I->click('Add to Cart');

// Checkout
$I->click('Checkout');

$order = factory(DanPowell\Shop\Models\Order::class)->make();

$I->submitForm('#createOrder', $order->toArray());


$I->seeCurrentRouteIs('shop.order.store');


// Continue to confirmation
//$I->click('Continue to confirmation');


// Check delivery option exists in config

// Check delivery option matches cart total

// Check billing & delivery country exists in config


?>