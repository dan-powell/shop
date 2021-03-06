<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(DanPowell\Shop\Models\Product::class, function (Faker\Generator $faker) {
    return [
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
	    'title' => $faker->sentence(rand(2, 5)),
	    'description' => $faker->paragraphs(6, true),
	    'slug' => $faker->slug,
		'price' => $faker->randomFloat(2, 1, 5000),
	    'price_offer' => $faker->randomElement([$faker->randomFloat(2, 1, 3000), NULL]),
	    'weight' => $faker->randomFloat(2, 0, 2000),
	    'width' => $faker->randomFloat(2, 0, 2000),
	    'height' => $faker->randomFloat(2, 0, 2000),
	    'length' => $faker->randomFloat(2, 0, 2000),
	    'stock' => $faker->numberBetween(0, 100),
	    'featured' => $faker->randomElement([0, 1]),
	    'meta_title' => $faker->sentence(rand(1, 4)),
	    'meta_description' => $faker->paragraph(1),
		'rank' => $faker->numberBetween(0, 100),
    ];
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'featured', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['featured' => 1]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'published', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['published' => 1]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'unpublished', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['published' => 0]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'inStock', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['stock' => 10]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'inStockAllowNegative', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['stock' => 10, 'allow_negative_stock' => 1]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'outOfStock', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['stock' => 0, ]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'outOfStockAllowNegative', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['stock' => 0, 'allow_negative_stock' => 1]);
});

$factory->defineAs(DanPowell\Shop\Models\Product::class, 'onOffer', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Product::class);

	return array_merge($model, ['price' => 20, 'price_offer' => 10,]);
});