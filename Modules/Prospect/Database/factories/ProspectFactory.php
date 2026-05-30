<?php

use Faker\Generator as Faker;
use Modules\Prospect\Entities\Prospect;
use Modules\User\Entities\User;

$factory->define(Prospect::class, function (Faker $faker) {
    return [
        'organization_name' => $faker->company,
        'poc_user_id' => function () {
            return User::factory()->create()->id;
        },
        'proposal_sent_date' => $faker->date(),
        'domain' => $faker->word,
        'customer_type' => 'prospect',
        'budget' => $faker->numberBetween(100000, 5000000),
        'proposal_status' => 'draft',
        'rfp_link' => $faker->url,
        'proposal_link' => $faker->url,
        'currency' => 'INR',
    ];
});
