<?php

return [
    'name' => 'Client',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'client-form-stages' => [
        'client-details' => [
            'display-name' => 'Client Details',
        ],

        'contact-persons' => [
            'display-name' => 'Contact Persons',
        ],

        'address' => [
            'display-name' => 'Address',
        ],

        'billing-details' => [
            'display-name' => 'Billing details',
        ],

        'contract' => [
            'display-name' => 'Contract',
        ],
    ],

    'client-contact-person-type'=>[
        'primary-billing-contact' => 'billing-contact',
        'general-point-of-contact' => 'general-contact',
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
            'display_name' => 'India',
        ],

        [
            'name' => 'united-states',
            'initials' => 'US',
            'id' => 2,
            'currency' => '$',
            'display_name' => 'United State',
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
        'quarterly' => [
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

    'currency-symbols' => [
        [
            'rupee' => '₹',
        ],

        [
            'dollar' => '$',
        ],

        [
            'euro' => '€',
        ],
        [
            'swiss-franc' => '₣',
        ],
        [
            'gbp' => '£',
        ],
    ],

    'service-rate-terms' => [
        'per_hour' => [
            'slug' => 'per_hour',
            'label' => 'Per Hour',
            'short-label' => '/hour',
        ],
        'per_month' => [
            'slug' => 'per_month',
            'label' => 'Per Month',
            'short-label' => '/month',
        ],
        'per_quarter' => [
            'slug' => 'per_quarter',
            'label' => 'Per Quarter',
            'short-label' => '/quarter',
        ],
        'per_year' => [
            'slug' => 'per_year',
            'label' => 'Per Year',
            'short-label' => '/year',
        ],
        'per_resource' => [
            'slug' => 'per_resource',
            'label' => 'Per Resource',
            'short-label' => '/resource',
        ],
        'overall' => [
            'slug' => 'overall',
            'label' => 'Overall',
            'short-label' => 'overall',
        ],
    ],

    'meta_keys' => [
        'contract_level' => [
            'key' => 'contract_level',
            'value' => [
                'client' => [
                    'key' => 'client',
                    'label' => 'Client level',
                ],
                'project' => [
                    'key' => 'project',
                    'label' => 'Project level',
                ],
            ],
        ],
        'last_updated_at' => [
            'key' => 'last_updated_at',
            'value' => 'Last refreshed at',
        ],
    ],
];
