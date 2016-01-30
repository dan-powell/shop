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

$factory->define(DanPowell\Shop\Models\Option::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'type' => $faker->randomElement(config('shop.option_types')),
        'config' => json_encode(['Option1', 'Option 2']),
    ];
});