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

$factory->define(DanPowell\Shop\Models\Image::class, function (Faker\Generator $faker) {

	$image = $faker->image('public/images', 800, 600, 'cats', false);
	//rename($image, 'public/images/' . $newfile);

    return [
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
	    'title' => $faker->sentence(rand(2, 5)),
	    'path' => 'images',
		'filename' => $image,
	    'alt' => $faker->sentence(rand(4, 10)),
    ];
});