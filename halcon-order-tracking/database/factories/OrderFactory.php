<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'invoice_number'   => strtoupper($faker->unique()->bothify('INV-####??')),
        'customer_name'    => $faker->company,
        'customer_number'  => $faker->bothify('CLI-###'),
        'rfc'              => strtoupper($faker->bothify('???######???')),
        'fiscal_address'   => $faker->streetAddress . ', ' . $faker->city,
        'fiscal_email'     => $faker->companyEmail,
        'delivery_address' => $faker->streetAddress . ', ' . $faker->city . ', ' . $faker->state,
        'notes'            => $faker->optional(0.5)->sentence,
        'order_date'       => $faker->dateTimeBetween('-60 days', 'now'),
        'status'           => $faker->randomElement([
            Order::STATUS_ORDERED,
            Order::STATUS_IN_PROCESS,
            Order::STATUS_IN_ROUTE,
            Order::STATUS_DELIVERED,
        ]),
        'deleted'          => 0,
        'created_by'       => User::inRandomOrder()->first()->id ?? factory(User::class)->create()->id,
    ];
});
