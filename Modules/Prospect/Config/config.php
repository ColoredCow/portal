<?php

return [
    'name' => 'Prospect',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ],

    'prospect-form-stages' => [
        'client-details' => [
            'display-name' => 'Client Details',
        ],

        'contact-persons' => [
            'display-name' => 'Contact Persons',
        ],

        'prospect-requirements' => [
            'display-name' => 'Requirements',
        ],
    ],

    'prospect-show-tabs' => [
        'prospect-info' => [
            'display-name' => 'Prospect info',
        ],

        'prospect-progress' => [
            'display-name' => 'Progress',
        ],
    ],

    'default-prospect-show-tab' => 'prospect-progress',

    'checklist' => [
        'convert-into-client',
        'contract',
        'proposal',
        'nda',
        'introduction',
    ],
];
