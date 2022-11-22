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
        'tester' => 'Tester(QA)',
        'solution_architect' => 'Solution Architect',
        'customer_support' => 'Customer Support',
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
    ],
    'stack' => ['C', 'C++', ' C#', 'Java', 'Flask','Elixir', 'Angular', 'Mongodb', 'Koa','Phoenix', 'ExpressJS', 'Asp .NET', 'Spring Boot', 'Django','Ruby on Rails','CakePHP', 'Javascript', 'bootstrap','Laravel','React-js', 'Tailwind', 'PHP', 'SQL', 'HTML', 'CSS', 'Python', 'Swift', 'Golang (Go)', 'R', 'TypeScript', 'Shell', 'PowerShell', 'Perl', 'Haskell', 'Kotlin', 'Visual Basic .NET', 'Delphi'],
];
