<?php

return [
    'gsuite' => [
        'service-account-impersonate' => env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'),
        'client-hd' => env('GOOGLE_CLIENT_HD', ''),
    ],
    'http_response_messages' => [
        '403' => 'Forbidden! You don\'t have necessary permissions to access this area. Please contact your administrator.',
        '404' => 'Sorry, the page you are looking for could not be found.',
        '419' => 'The page has expired due to inactivity. Please refresh and try again.',
        '429' => 'Too many requests! Please try again.',
        '500' => 'Whoops, looks like something went wrong. Please try again.',
        '503' => 'The server is currently unable to handle the request. Please check after some time.',
    ],
    'date_format' => 'Y-m-d',
    'datetime_format' => 'Y-m-d H:i:s',
    'display_date_format' => 'd/m/Y',
    'full_display_date_format' => 'F d, Y',
    'display_datetime_format' => 'Y-m-d\TH:i',
    'calendar_datetime_format' => 'Y-m-d\TH:i:s',
    'input_date_format' => 'dd/mm/yyyy',
    'modules' => [
        'hr',
        'finance',
        'weeklydose',
    ],
    'countries' => [
        'india' => [
            'title' => 'India',
            'currency' => 'INR',
        ],
        'united-states' => [
            'title' => 'United States',
            'currency' => 'USD',
        ],
    ],
    'pagination_size' => 10,
    'hr' => [
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
        ],

        'template-variables' => [
            'applicant-name' => '|*applicant_name*|',
            'interview-time' => '|*interview_time*|',
            'job-title' => '|*job_title*|',
        ],

        'default' => [
            'email' => env('HR_DEFAULT_FROM_EMAIL', 'employeeportal@example.com'),
            'name' => env('HR_DEFAULT_FROM_NAME', 'Employee Portal Careers'),
        ],
        'interview-time-format' => 'h:i a',
        'no-show-hours-limit' => 2,
        'application-meta' => [
            'keys' => [
                'form-data' => 'form-data',
                'change-job' => 'change-job',
                'no-show' => 'no-show',
                'custom-mail' => 'custom-mail',
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
                'title' => 'Sent-For-Approval',
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
        ],
        'defaults' => [
            'scheduled_person_id' => 1,
        ],
    ],
    'finance' => [
        'invoice' => [
            'status' => [
                'unpaid' => 'Unpaid',
                'paid' => 'Paid',
            ],
        ],
        'gst' => '18',
        'reports' => [
            'list-previous-months' => 6,
        ],
        'conversion-rate-usd-to-inr' => 65,
    ],
    'currency' => [
        'INR' => [
            'name' => 'Indian Rupees',
            'symbol' => '₹',
        ],
        'USD' => [
            'name' => 'US Dollars',
            'symbol' => '$',
        ],
    ],
    'payment_types' => [
        'cheque' => 'Cheque',
        'cash' => 'Cash',
        'wire-transfer' => 'Wire Transfer',
    ],
    'cheque_status' => [
        'received' => 'Received',
        'cleared' => 'Cleared',
        'bounced' => 'Bounced',
    ],
    'project' => [
        'status' => [
            'active' => 'Active',
            'inactive' => 'Inactive',
        ],
        'type' => [
            'fixed_budget' => 'Fixed Budget',
            'hourly' => 'Hourly',
        ],
    ],
];
