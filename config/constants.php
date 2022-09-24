<?php

return [
    'gsuite' => [
        'service-account-impersonate' => env('GOOGLE_SERVICE_ACCOUNT_IMPERSONATE'),
        'client-hd' => env('GOOGLE_CLIENT_HD', ''),
        'config-path' => env('GOOGLE_APPLICATION_CREDENTIALS')
    ],
    'google' => [
        'vision-api-key' => env('GOOGLE_VISION_API_KEY'),
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
    'display_time_format' => 'h:ia',
    'full_display_date_format' => 'H:ia M d, Y',
    'full_display_date_format' => 'M d, Y',
    'display_datetime_format' => 'Y-m-d\TH:i',
    'calendar_datetime_format' => 'Y-m-d\TH:i:s',
    'input_date_format' => 'dd/mm/yyyy',
    'display_daydatetime_format' => 'D h:ia, jS M Y',
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
            'verification-link' => '|*verification_link*|'
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
                'class' => 'badge badge-success',
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
        'offer-letters-dir' => 'offer-letters',
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
        'payments' => [
            'modes' => [
                'cash' => 'App\Models\Finance\PaymentModes\Cash',
                'wire-transfer' => 'App\Models\Finance\PaymentModes\WireTransfer',
                'cheque' => 'App\Models\Finance\PaymentModes\Cheque',
            ],
        ],
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
    'payment_modes' => [
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
    'months' => [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ],

    'google_application_credentials' => env('GOOGLE_APPLICATION_CREDENTIALS'),

    'website_url' => env('WEBSITE_URL', 'https://coloredcow.com'),
    'cube_js_url' => env('CUBE_JS_URL', 'http://localhost:4000/cubejs-api/v1'),
    'website_upload_dir' => env('WEBSITE_UPLOAD_DIR'),
    'timezone' => [
        'indian' => 'Asia/Kolkata',
    ],

    'amount-to-words' => [
        '0' => '',
        '1' => 'one',
        '2' => 'two',
        '3' => 'three',
        '4' => 'four',
        '5' => 'five',
        '6' => 'six',
        '7' => 'seven',
        '8' => 'eight',
        '9' => 'nine',
        '10' => 'ten',
        '11' => 'eleven',
        '12' => 'twelve',
        '13' => 'thirteen',
        '14' => 'fourteen',
        '15' => 'fifteen',
        '16' => 'sixteen',
        '17' => 'seventeen',
        '18' => 'eighteen',
        '19' =>'nineteen',
        '20' => 'twenty',
        '30' => 'thirty',
        '40' => 'forty',
        '50' => 'fifty',
        '60' => 'sixty',
        '70' => 'seventy',
        '80' => 'eighty',
        '90' => 'ninety'
    ],
    'bar-Chart-Colors' => [
    'color1Name' => '#ff0080',
    'color2Name' => '#00bfff',
    'color3Name' => '#ffff00',
    ]
];
