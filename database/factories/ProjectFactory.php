<?php

use Faker\Generator as Faker;
use App\Models\Project;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'client_id' => function () {
            return factory('App\Models\Client')->create()->id;
        },
        'client_project_id' => rand(1, 100),
        'status' => 'active',
        'invoice_email' => $faker->unique()->email,
    ];
});
