<?php

use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    return [
        'hr_applicant_id' => '',
        'hr_job_id' => '',
        'status' => '',
        'pending_approval_from' => '',
        'resume' => '',
        'reason_for_eligibility' => '',
        'autoresponder_subject' => '',
        'autoresponder_body' => ''
    ];
});
