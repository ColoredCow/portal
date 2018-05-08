<?php

return [
    'date_format' => 'Y-m-d',
    'display_date_format' => 'd/m/Y',
    'modules' => [
        'hr',
        'finance',
        'weeklydose'
    ],
    'countries' => [
        'india' => [
            'title' => 'India',
            'currency' => 'INR'
        ],
        'united-states' => [
            'title' => 'United States',
            'currency' => 'USD'
        ],
    ],
    'pagination_size' => 10,
    'hr' => [
        'status' => [
            'new' => [
                'label' => 'new',
                'title' => 'New',
                'class' => 'badge badge-info'
            ],
            'rejected' => [
                'label' => 'rejected',
                'title' => 'Rejected',
                'class' => 'badge badge-danger'
            ],
            'in-progress' => [
                'label' => 'in-progress',
                'title' => 'In progress',
                'class' => 'badge badge-warning'
            ],
            'confirmed' => [
                'label' => 'confirmed',
                'title' => 'Accepted in this round',
                'class' => 'badge badge-success'
            ],
            'completed' => [
                'label' => 'completed',
                'title' => 'Cleared all rounds',
                'class' => 'badge badge-success'
            ],
            'onboarded' => [
                'label' => 'onboarded',
                'title' => 'Onboarded team',
                'class' => 'badge badge-success'
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
