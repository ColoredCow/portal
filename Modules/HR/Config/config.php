<?php

return [
    'name' => 'HR',
    'applicationEvaluation' => [
        'cutoffScore' => 10,
    ],
    'opportunities' => [
        'job' => [
            'title' => 'Job',
            'type' => 'recruitment',
        ],
        'internship' => [
            'title' => 'Internship',
            'type' => 'recruitment',
        ],
        'volunteer' => [
            'title' => 'Volunteer',
            'type' => 'volunteer',
        ],
        'domains' => [
            'engineering' => 'Engineering',
            'design' => 'Design',
            'marketing' => 'Marketing'
        ],

    ],

    'opportunities-status' => [
        'draft' => 'Draft',
        'published' => 'Published',
        'closed' => 'Closed'
    ],

    'post-type' => [
        'career' => 'Career',
    ],

    'template-variables' => [
        'applicant-name' => '|*applicant_name*|',
        'interview-time' => '|*interview_time*|',
        'job-title' => '|*job_title*|',
    ],

    'default' => [
        'email' => env('HR_DEFAULT_FROM_EMAIL', 'portal@coloredcow.com'),
        'name' => env('HR_DEFAULT_FROM_NAME', 'ColoredCow Portal Careers'),
    ],
    'interview-time-format' => 'h:i a',
    'no-show-hours-limit' => 2,
    'application-meta' => [
        'keys' => [
            'form-data' => 'form-data',
            'change-job' => 'change-job',
            'no-show' => 'no-show',
            'custom-mail' => 'custom-mail',
            'approved' => 'approved',
            'onboarded' => 'onboarded',
        ],
        'reasons-no-show' => [
            'absent-applicant' => 'Applicant is absent',
            'absent-interviewer' => 'Interviewer is absent',
        ],
    ],
    'status' => [
        'new' => [
            'label' => 'new',
            'title' => 'New',
            'class' => 'badge badge-info',
        ],
        'on-hold' => [
            'label' => 'on-hold',
            'title' => 'On hold',
            'class' => 'badge badge-secondary',
        ],
        'no-show' => [
            'label' => 'no-show',
            'title' => 'No show',
            'class' => 'badge badge-danger',
        ],
        'no-show-reminded' => [
            'label' => 'no-show-reminded',
            'title' => 'No show reminded',
            'class' => 'badge badge-danger',
        ],
        'rejected' => [
            'label' => 'rejected',
            'title' => 'Rejected',
            'class' => 'badge badge-danger',
        ],
        'in-progress' => [
            'label' => 'in-progress',
            'title' => 'In progress',
            'class' => 'badge badge-warning',
        ],
        'sent-for-approval' => [
            'label' => 'sent-for-approval',
            'title' => 'Sent for Approval',
            'class' => 'badge badge-info',
        ],
        'confirmed' => [
            'label' => 'confirmed',
            'title' => 'Accepted in this round',
            'class' => 'badge badge-success',
        ],
        'approved' => [
            'label' => 'approved',
            'title' => 'Approved',
            'class' => 'badge badge-success',
        ],
        'onboarded' => [
            'label' => 'onboarded',
            'title' => 'Onboarded',
            'class' => 'badge badge-success',
        ],
        'custom-mail' => [
            'label' => 'custom-mail',
            'title' => 'Custom mail',
            'class' => 'badge badge-success p-1',
        ],
    ],
    'defaults' => [
        'scheduled_person_id' => env('HR_DEFAULT_SCHEDULED_PERSON', 1),
    ],
    'daily-appointment-slots' => [
        'total' => 6,
        'max-reserved-allowed' => 3,
    ],
    'offer-letters-dir' => 'offer-letters',
];
