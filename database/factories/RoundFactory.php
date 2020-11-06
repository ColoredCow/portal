<?php
namespace Database\Factories;

use Faker\Generator as Faker;
use App\Models\HR\Round;

$factory->define(Round::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'guidelines' => $faker->paragraphs(5, true),
        'confirmed_mail_template' => [
            'subject' => $faker->sentence,
            'body' => $faker->paragraphs(5, true),
        ],
        'rejected_mail_template' => [
            'subject' => $faker->sentence,
            'body' => $faker->paragraphs(5, true),
        ],
    ];
});
