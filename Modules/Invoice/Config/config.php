<?php

return [
    'name' => 'Invoice',
    'status' => [
        'sent' => 'Sent',
        'paid' => 'Paid',
        'pending' => 'Pending',
        'disputed' => 'Disputed'
    ],

    'default-date-format' => 'd M Y',

    'mail' => [
        'unpaid-invoice' => [
            'email' => env('INVOICE_UNPAID_LIST_EMAIL', 'finance@coloredcow.com'),
            'name' => env('INVOICE_UNPAID_LIST_NAME', 'ColoredCow Finance')
        ],
        'send-invoice' => [
            'email' => env('INVOICE_UNPAID_LIST_EMAIL', 'finance@coloredcow.com'),
            'name' => env('INVOICE_UNPAID_LIST_NAME', 'ColoredCow Finance')
        ],
    ],

    'pending-invoice-mail' => [
        'pending-invoice' => [
            'email' => env('INVOICE_UNPAID_LIST_EMAIL', 'finance@coloredcow.com'),
            'name' => env('INVOICE_UNPAID_LIST_NAME', 'ColoredCow Finance')
        ]
    ],

    'region' => [
        'indian' => 'indian',
        'international' => 'international',
    ],

    'invoice-details' => [
        'billing-state' => 'Haryana',
        'igst' => '18%',
        'cgst' => '9%',
        'sgst' => '9%'
    ],

    'financial-month-details' => [
        'financial_year_start_month' => '04',
        'financial_year_end_month' => '03'
    ],

    'tax-details' => [
        'igst' => 0.18,
        'cgst' => 0.09,
        'sgst' => 0.09
    ],

    'finance-details' => [
        'transaction-method' => [
            'label' => 'Transaction Method',
            'value' => [
                'bank-transfer' => [
                    'key' => 'bank-transfer',
                    'value' => 'Bank Transfer',
                ],
            ]
        ],
        'bank-address' => env('BANK_ADDRESS', ''),
        'swift-code' => env('SWIFT_CODE', ''),
        'ifci-code' => env('IFCI_CODE', ''),
        'account-number' => env('ACCOUNT_NUMBER', ''),
        'holder-name' => 'ColoredCow Consulting Pvt. Ltd.',
        'phone' => env('COLOREDCOW_PHONE', ''),
        'pan' => env('PAN_NUMBER', ''),
        'gstin' => env('GSTIN', ''),
        'hsn-code' => env('HSN_CODE', ''),
        'cin-no' => env('CIN_NO', ''),
        'correspondent-bank' => env('CORRESPONDENT_BANK', ''),
        'correspondent-bank-swift-code' => env('CORRESPONDENT_BANK_SWIFT_CODE', ''),
        'beneficiary-bank-of-usd' => env('BENEFICIARY_BANK_OF_USD', ''),
    ],

    'coloredcow-details' => [
        'name' => 'ColoredCow Consulting Pvt. Ltd.',
        'gurgaon' => [
            'address-line-1' => 'F-61, Suncity, Sector - 54',
            'address-line-2' => 'Gurgaon, Haryana, 122003, India'
        ]
    ],

    'templates' => [
        'setting-key' => [
            'send-invoice' => [
                'key' => 'send_invoice',
                'subject' => 'send_invoice_subject',
                'body' => 'send_invoice_body',
                'template-variables' => [
                    'subject' => [
                        'project-name' => '|*project_name*|',
                        'term' => '|*term*|',
                        'year' => '|*year*|',
                    ],
                    'body' => [
                        'billing-person-name' => '|*billing_person_name*|',
                        'invoice-amount' => '|*invoice_amount*|',
                        'invoice-number' => '|*invoice_number*|',
                        'term' => '|*term*|',
                        'year' => '|*year*|',
                    ],
                ],
            ],
            'invoice-reminder' => [
                'key' => 'invoice_reminder',
                'subject' => 'invoice_reminder_subject',
                'body' => 'invoice_reminder_body',
                'template-variables' => [
                    'subject' => [
                        'project-name' => '|*project_name*|',
                        'term' => '|*term*|',
                        'year' => '|*year*|',
                    ],
                    'body' => [
                        'billing-person-name' => '|*billing_person_name*|',
                        'invoice-amount' => '|*invoice_amount*|',
                        'invoice-number' => '|*invoice_number*|',
                    ],
                ],
            ],
            'received-invoice-payment' => [
                'key' => 'received_invoice_payment',
                'subject' => 'received_invoice_payment_subject',
                'body' => 'received_invoice_payment_body',
                'template-variables' => [
                    'subject' => [
                        'project-name' => '|*project_name*|',
                        'term' => '|*term*|',
                        'year' => '|*year*|',
                    ],
                    'body' => [
                        'billing-person-name' => '|*billing_person_name*|',
                        'invoice-number' => '|*invoice_number*|',
                        'currency' => '|*currency*|',
                    ],
                ],
            ]
        ],
        'invoice' => [
            'clients' => [
                env('CUSTOM_INVOICE_CLIENT_1', '') => 'custom-invoice-template-1'
            ],
            'projects' => []
        ]
    ],
];
