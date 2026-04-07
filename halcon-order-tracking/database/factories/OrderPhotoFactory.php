<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\OrderPhoto;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(OrderPhoto::class, function (Faker $faker) {
    return [
        'order_id'    => factory(Order::class)->create()->id,
        'photo_type'  => $faker->randomElement([
            OrderPhoto::TYPE_LOADING,
            OrderPhoto::TYPE_DELIVERY,
        ]),
        'photo_url'   => 'order-photos/' . $faker->uuid . '.jpg',
        'uploaded_by' => User::inRandomOrder()->first()->id ?? factory(User::class)->create()->id,
        'uploaded_at' => $faker->dateTimeBetween('-30 days', 'now'),
    ];
});
