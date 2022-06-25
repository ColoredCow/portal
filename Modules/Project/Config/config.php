<?php

return [
    'name' => 'Project',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'halted' => 'Halted'
    ],
    'designation' => [
        'project_manager' => 'Project Manager',
        'developer' => 'Developer',
        'designer' => 'Designer',
    ],
    'type' => [
        'monthly-billing' => 'Monthly Billing',
        'fixed-budget' => 'Fixed Budget'
    ],
    'meta_keys' => [
        'billing_level' => [
            'key' => 'billing_level',
            'value' => [
                'client' => [
                    'key' => 'client',
                    'label' => 'Client level',
                ],
                'project' => [
                    'key' => 'project',
                    'label' => 'Project level',
                ]
            ]
        ],
        'last_updated_at' => [
            'key' => 'last_updated_at',
            'value' => 'Last refreshed at',
        ]
    ]
];
