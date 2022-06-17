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
        ]
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
    ],

    'coloredcow-details' => [
        'name' => 'ColoredCow Consulting Pvt. Ltd.',
        'gurgaon' => [
            'address-line-1' => 'F-61, Suncity, Sector - 54',
            'address-line-2' => 'Gurgaon, Haryana, 122003, India'
        ]
    ]
];
