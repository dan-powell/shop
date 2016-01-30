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

$factory->define(DanPowell\Shop\Models\Extra::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph(3),
        'price' => $faker->randomElement([0, $faker->randomFloat(2, 0, 1500)]),
        'stock' => $faker->randomElement([null, $faker->numberBetween(0, 100)]),
        'allow_negative_stock' => $faker->randomElement([0, 1]),
    ];
});

$factory->defineAs(DanPowell\Shop\Models\Extra::class, 'stocked', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Extra::class);

    return array_merge($model, ['stock' => $faker->numberBetween(10, 50)]);
});