<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\Client;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'is_active' => true,
        'gst_num' => null,
    ];
});
