<?php

use Faker\Generator as Faker;
use App\Models\Organization;

$factory->define(Organization::class, function (Faker $faker) {
    $companyName = $faker->company;
    return [
        'slug' => Organization::generateSlug($companyName),
        'name' => $companyName,
        'contact_email' => $faker->unique()->email,
    ];
});
