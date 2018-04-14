<?php

return [
    'date_format' => 'Y-m-d',
    'display_date_format' => 'd/m/Y',
    'countries' => [
        'india' => 'India',
        'united-states' => 'United States',
    ],
    'hr' => [
        'round' => [
            'status' => [
                'new' => 'new',
                'rejected' => 'rejected',
                'in-progress' => 'in-progress',
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
