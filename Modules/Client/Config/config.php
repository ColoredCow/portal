<?php

return [
    'name' => 'Client',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive'
    ],

    'client-form-stages' => [
        'client-details' => [
            'display-name' => 'Client Details'
        ],

        'client-type' => [
            'display-name' => 'Client Type'
        ]
    ],

    'default-client-form-stage' => 'client-details',

    'countries' => [
        [
            'name' => 'india',
            'initials' => 'IN',
            'currency' => '₹',
            'display_name' => 'India'
        ],

        [
            'name' => 'united-states',
            'initials' => 'US',
            'currency' => '$',
            'display_name' => 'United State'
        ],
    ]
];
