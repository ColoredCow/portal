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
        'basic_salary' => env('BASIC_SALARY', '30000')
    ]
];
