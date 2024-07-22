<?php

return [
    'name' => 'Salary',
    'settings' => [
        'percentage_applies_on' => [
            'basic_salary' => 'gross_salary',
            'employee_esi' => 'gross_salary',
            'employer_esi' => 'gross_salary',
            'hra' => 'basic_salary',
            'employee_epf' => 'basic_salary',
            'employer_epf' => 'basic_salary',
            'administration_charges' => 'basic_salary',
            'edli_charges' => 'basic_salary',
        ],
        'labels' => [
            'gross_salary' => 'Gross Salary',
            'basic_salary' => 'Basic Salary',
            'employee_esi' => 'Employee ESI',
            'employer_esi' => 'Employer ESI',
            'hra' => 'HRA',
            'employee_epf' => 'Employee EPF',
            'employer_epf' => 'Employer EPF',
            'administration_charges' => 'Administration Charges',
            'edli_charges' => 'EDLI Charges',
            'medical_allowance' => 'Medical Allowance',
            'transport_allowance' => 'Transport Allowance',
            'food_allowance' => 'Food Allowance',
            'employee_esi_limit' => 'Employee ESI Limit',
            'edli_charges_limit' => 'EDLI Charges Limit',
            'health_insurance' => 'Health Insurance',
            'employer_esi_limit' => 'Employer ESI Limit',
        ],
    ],

    'default' => [
        'email' => env('HR_EMPLOYEE_DEFAULT_EMAIL', 'hr@coloredcow.com'),
        'name' => env('HR_EMPLOYEE_DEFAULT_NAME', 'Mohit Sharma'),
    ],

    'type' => [
        'employee_salary' => [
            'slug' => 'employee-salary',
        ],
        'contractor_fee' => [
            'slug' => 'contractor-fee',
        ],
    ],
    
    'payroll_type' => [
        'contractor' => [
            'label' => 'Contractor',
            'slug' => 'contractor',
        ],
        'full_time' => [
            'label' => 'Full Time',
            'slug' => 'full-time',
        ],
    ],
];
