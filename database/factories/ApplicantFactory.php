<?php

namespace Database\Factories;

use App\Models\HR\Applicant;
use Faker\Generator as Faker;

$factory->define(Applicant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->email,
        'phone' => $faker->phoneNumber,
        'college' => $faker->word,
        'graduation_year' => $faker->year,
        'course' => $faker->word,
        'linkedin' => $faker->url,
    ];
});
