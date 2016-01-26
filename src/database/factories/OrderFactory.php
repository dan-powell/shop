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


$factory->define(DanPowell\Shop\Models\Order::class, function (Faker\Generator $faker) {

	$faker->addProvider(new Faker\Provider\en_GB\Person($faker));
	$faker->addProvider(new Faker\Provider\en_GB\Address($faker));
	$faker->addProvider(new Faker\Provider\en_GB\PhoneNumber($faker));

    return [
        'created_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),
        'updated_at' => $faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now'),

		'session_id' => $faker->sha1,

		'cart' => '',

		'shipping_type' => $faker->randomElement(array_keys(config('shop.order_status_types'))),
		'status' => $faker->randomElement(array_keys(config('shop.order_status_types'))),
		'total' => $faker->randomFloat(2, 1, 3000),

		'firstName' => $faker->firstName,
		'lastName' => $faker->lastName,

		'billingAddress1' => $faker->address,
		'billingAddress2' => $faker->secondaryAddress,
		'billingCity' => $faker->city,
		'billingPostcode' => $faker->postcode,
		'billingState' => $faker->county,
		'billingCountry' => $faker->country,
		'billingPhone' => $faker->phoneNumber,
		'shippingAddress1' => $faker->address,
		'shippingAddress2' => $faker->secondaryAddress,
		'shippingCity' => $faker->city,
		'shippingPostcode' => $faker->postcode,
		'shippingState' => $faker->county,
		'shippingCountry' => $faker->country,
		'shippingPhone' => $faker->phoneNumber,
		'email' => $faker->safeEmail,
		'notes' => $faker->paragraphs(2, true),
		'instructions' => $faker->paragraphs(1, true)

    ];
});

$factory->defineAs(DanPowell\Shop\Models\Order::class, 'paid', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Order::class);

	return array_merge($model, ['status' => 1]);
});

$factory->defineAs(DanPowell\Shop\Models\Order::class, 'prospective', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Order::class);

	return array_merge($model, ['status' => 0]);
});

$factory->defineAs(DanPowell\Shop\Models\Order::class, 'processed', function ($faker) use ($factory) {
	$model = $factory->raw(DanPowell\Shop\Models\Order::class);

	return array_merge($model, ['status' => 2]);
});