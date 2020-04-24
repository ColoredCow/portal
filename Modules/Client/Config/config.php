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

        'contact-persons' => [
            'display-name' => 'Contact Persons'
        ],

        'address' => [
            'display-name' => 'Address'
        ],

        'billing-details' => [
            'display-name' => 'Billing details'
        ],
    ],

    'default-client-form-stage' => 'client-details',

    'countries' => [
        [
            'name' => 'india',
            'id' => 1,
            'initials' => 'IN',
            'currency' => '₹',
            'display_name' => 'India'
        ],

        [
            'name' => 'united-states',
            'initials' => 'US',
            'id' => 2,
            'currency' => '$',
            'display_name' => 'United State'
        ],
    ],

    'billing-frequency' => [
        [
            'id' => 1,
            'name' => 'Monthly',

            'currency' => '₹',
            'display_name' => 'India'
        ],

        [
            'name' => 'united-states',
            'initials' => 'US',
            'id' => 2,
            'currency' => '$',
            'display_name' => 'United State'
        ],
    ]
];
