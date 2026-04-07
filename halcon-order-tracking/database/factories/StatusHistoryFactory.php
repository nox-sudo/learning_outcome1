<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\StatusHistory;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(StatusHistory::class, function (Faker $faker) {
    $statuses = [
        Order::STATUS_ORDERED,
        Order::STATUS_IN_PROCESS,
        Order::STATUS_IN_ROUTE,
        Order::STATUS_DELIVERED,
    ];

    $oldIndex = $faker->numberBetween(0, 2);

    return [
        'order_id'   => factory(Order::class)->create()->id,
        'old_status' => $faker->optional(0.8)->randomElement($statuses),
        'new_status' => $statuses[$oldIndex + 1],
        'changed_by' => User::inRandomOrder()->first()->id ?? factory(User::class)->create()->id,
        'changed_at' => $faker->dateTimeBetween('-30 days', 'now'),
    ];
});
