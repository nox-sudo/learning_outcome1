<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\User;
use App\Models\Role;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'name'              => $faker->name,
        'email'             => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password'          => bcrypt('password'),
        'role_id'           => Role::inRandomOrder()->first()->id ?? factory(Role::class)->create()->id,
        'active'            => $faker->boolean(90), // 90% chance active
        'remember_token'    => Str::random(10),
    ];
});
