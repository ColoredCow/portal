<?php

use App\Models\HR\Employee;
use Faker\Generator as Faker;

$factory->define(Employee::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'designation' => $faker->jobTitle,
        'joined_on' => $faker->date,
        'user_id' => null,
    ];
});
