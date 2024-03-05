<?php

return [
    'name' => 'Project',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'halted' => 'Halted',
    ],
    'designation' => [
        'project_manager' => 'Project Manager',
        'developer' => 'Developer',
        'designer' => 'Designer',
        'tester' => 'Tester(QA)',
        'solution_architect' => 'Solution Architect',
        'customer_support' => 'Customer Support',
        'consultant' => 'Consultant',
    ],
    'type' => [
        'monthly-billing' => 'Monthly Billing',
        'fixed-budget' => 'Fixed Budget',
    ],
    'project_colors' => ['#4cd5db','#ffc0cb','#ff91b2','#E59197','#fffdea'],
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
                ],
            ],
        ],
        'last_updated_at' => [
            'key' => 'last_updated_at',
            'value' => 'Last refreshed at',
        ],
    ],
];
