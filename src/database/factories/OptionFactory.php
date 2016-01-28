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
        'label' => $faker->word,
        'price_modifier' => $faker->randomElement([0, $faker->randomFloat(2, -1500, 1500)]),
    ];
});

$factory->defineAs(DanPowell\Shop\Models\Option::class, 'stocked', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Option::class);

    return array_merge($model, ['stock' => $faker->numberBetween(0, 50)]);
});
