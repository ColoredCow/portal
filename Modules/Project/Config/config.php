<?php

return [
    'name' => 'Project',
    'status' => [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'halted' => 'Halted'
    ],
    'designation' => [
        'developer' => 'Developer',
            'designer' => 'Designer',
            'tester' => 'Tester(QA)',
            'project_manager' => 'Project Manager',
            'senior_software_engineer' => 'Senior Software Engineer',
            'software_engineer' => 'Software Engineer',
            'product_designer' => 'Product Designer',
            'graphics_designer' => 'Graphics Designer',
            'solution_architect' => 'Solution Architect',
            'finance_lead' => 'Finance Lead',
            'quality_analyst' => 'Quality Analyst',
            'chief_executive-officer' => 'Chief Executive Officer',
            'consultant' => 'Consultant'
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
