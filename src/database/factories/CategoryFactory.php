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

$factory->define(DanPowell\Shop\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraphs(3, true),
        'slug' => $faker->slug,
        'rank' => $faker->numberBetween(0, 100),
        'published' => $faker->randomElement([0, 1]),
        'meta_title' => $faker->sentence(rand(1, 4)),
        'meta_description' => $faker->paragraph(1),
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
    ];
});

$factory->defineAs(DanPowell\Shop\Models\Category::class, 'published', function ($faker) use ($factory) {
    $model = $factory->raw(DanPowell\Shop\Models\Category::class);

    return array_merge($model, ['published' => 1]);
});