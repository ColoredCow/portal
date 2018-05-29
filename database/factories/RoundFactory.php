<?php

use Faker\Generator as Faker;
use App\Models\HR\Round;

$factory->define(Round::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'guidelines' => $faker->paragraph,
        'confirmed_mail_template' => [
            'subject' => str_random(20),
            'body' => str_random(80),
        ],
        'rejected_mail_template' => [
            'subject' => str_random(20),
            'body' => str_random(80),
        ],
    ];
});
