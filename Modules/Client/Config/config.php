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

    'client-contact-person-type'=>[
        'primary-billing-contact' => 'billing-contact',
        'general-Point-of-contact' => 'general-contact',
        'secondary-billing-contact' => 'secondary-contact',
        'tertiary-billing-contact' => 'tertiary-contact',
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

    // Todo: Need to store these values in database
    'billing-frequency' => [
        'net-15-days' => [
            'id' => 1,
            'name' => 'Net 15 days',
        ],
        'monthly' => [
            'id' => 2,
            'name' => 'Monthly',
        ],
        'quaterly' => [
            'id' => 3,
            'name' => 'Quarterly',
        ],
        'yearly' => [
            'id' => 4,
            'name' => 'Yearly',
        ],
        'based-on-project-terms' => [
            'id' => 5,
            'name' => 'Based on project terms',
        ],
    ],

    'currency-symbols' =>[
        [
            'rupee' => '₹'
        ],

        [
            'dollar' => '$'
        ],

        [
            'pound' => '€'
        ],
    ]
];
