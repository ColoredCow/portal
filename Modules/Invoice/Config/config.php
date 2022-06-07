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
    ]
];
