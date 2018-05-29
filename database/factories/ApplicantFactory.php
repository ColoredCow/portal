<?php

use Faker\Generator as Faker;
use App\Models\HR\Applicant;

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
