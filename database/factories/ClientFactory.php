<?php

use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'emails' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
        'country' => $faker->country,
        'is_active' => true,
        'address' => $faker->address,
        'gst_num' => null,
    ];
});
