<?php
namespace Database\Factories;

use App\Models\HR\Round;
use Faker\Generator as Faker;

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
