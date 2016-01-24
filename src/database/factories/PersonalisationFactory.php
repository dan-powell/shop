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

$factory->define(DanPowell\Shop\Models\Personalisation::class, function (Faker\Generator $faker) {
    return [
        'label' => $faker->word,
        'type' => $faker->randomElement(config('shop.personalisation_types')),
        'price_modifier' => $faker->randomElement([0, $faker->numberBetween(-1000, 1000)]),
    ];
});