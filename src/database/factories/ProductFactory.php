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
	    'description' => $faker->paragraph(6),
	    'slug' => $faker->slug,
	    'price' => $faker->randomFloat(2, 0, 9999),
	    'price_offer' => $faker->randomElement([$faker->randomFloat(2, 0, 9999), NULL]),
	    'weight' => $faker->randomFloat(2, 0, 9999),
	    'width' => $faker->randomFloat(2, 0, 9999),
	    'height' => $faker->randomFloat(2, 0, 9999),
	    'length' => $faker->randomFloat(2, 0, 9999),
	    'quantity' => $faker->numberBetween(0, 100),
	    'featured' => $faker->randomElement([0, 1]),
	    'published' => $faker->randomElement([0, 1]),
	    'meta_title' => $faker->sentence(rand(1, 4)),
	    'meta_description' => $faker->paragraph(1),
		'rank' => $faker->numberBetween(0, 100),
    ];
});