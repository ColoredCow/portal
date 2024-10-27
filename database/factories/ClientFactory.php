<?php
namespace Database\Factories;

use App\Models\Client;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'is_active' => true,
        'gst_num' => null,
    ];
});
