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
        'title' => 'OptionTitle-' . $faker->word . $faker->numberBetween(0, 99),
        'stock' => $faker->randomElement([null, $faker->numberBetween(0, 100)]),
        'type' => $faker->randomElement(['radio', 'select', 'text', 'textarea']),
        'config' => [
            'OptionVal-' . $faker->word . $faker->numberBetween(0, 99),
            'OptionVal-' . $faker->word . $faker->numberBetween(0, 99)
        ],
        'description' => $faker->paragraph(3),
    ];
});

$factory->defineAs(DanPowell\Shop\Models\Option::class, 'radio', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Option::class);

    return array_merge($model, ['type' => 'radio']);
});

$factory->defineAs(DanPowell\Shop\Models\Option::class, 'select', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Option::class);

    return array_merge($model, ['type' => 'select']);
});

$factory->defineAs(DanPowell\Shop\Models\Option::class, 'text', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Option::class);

    return array_merge($model, ['type' => 'text']);
});

$factory->defineAs(DanPowell\Shop\Models\Option::class, 'textarea', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Option::class);

    return array_merge($model, ['type' => 'textarea']);
});