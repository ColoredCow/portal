<?php

use Faker\Generator as Faker;
use Modules\Prospect\Entities\Prospect;
use Modules\Prospect\Entities\ProspectEngagement;
use Modules\User\Entities\User;

$factory->define(ProspectEngagement::class, function (Faker $faker) {
    // FK dependencies: Prospect uses the module's legacy $factory->define
    // convention (see ProspectFactory), while the User model uses the modern
    // HasFactory trait and has no legacy factory — hence User::factory() here.
    return [
        'prospect_id' => function () {
            return factory(Prospect::class)->create()->id;
        },
        'project_id' => null,
        'short_descriptor' => $faker->slug(2),
        'year' => 2026,
        'stage' => 'inquiry',
        'owner_user_id' => function () {
            return User::factory()->create()->id;
        },
        'submission_due_date' => null,
        'proposal_sent_date' => null,
        'last_touch_date' => $faker->date(),
        'next_action' => $faker->sentence(),
        'drift_flag' => false,
        'notes_path' => null,
    ];
});
