<?php

namespace Database\Factories;

use App\Models\HR\Job;
use Faker\Generator as Faker;

$factory->define(Job::class, function (Faker $faker) {
    $types = ['job', 'internship'];

    return [
        'title' => $faker->jobTitle,
        'type' => $types[array_rand($types)],
        'posted_by' => $faker->unique()->email,
        'link' => $faker->url,
    ];
});
