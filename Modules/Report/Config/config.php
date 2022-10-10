<?php

return [
    'name' => 'Report',
    'report_type' => [
        'sales_and_marketing' => 'Sales and Marketing'
    ],

    'finance' =>  [
        'profit_and_loss' => [
            'particulars' => [
                'revenue' => [
                    'domestic' => [
                        'name' => 'Domestic',
                        'head' => 'Direct Income'
                    ],

                    'export' => [
                        'name' => 'Export',
                        'head' => 'Direct Income'
                    ],

                    'stripe_india' => [
                        'name' => 'Stripe India',
                        'head' => 'Direct Income'
                    ],

                    'stripe_international' => [
                        'name' => 'Stripe International',
                        'head' => 'Direct Income'
                    ],

                    'commission_received' => [
                        'name' => 'Commission Received',
                        'head' => 'Direct Income'
                    ],

                    'cash_back' => [
                        'name' => 'Cash Back',
                        'head' => 'Indirect income'
                    ],

                    'discount_received' => [
                        'name' => 'Discount Received',
                        'head' => 'Indirect income'
                    ],

                    'interest_on_f_d' => [
                        'name' => 'Interest on FD',
                        'head' => 'Indirect income'
                    ],

                    'foreign_exchange_loss' => [
                        'name' => 'Foreign Exchange Loss',
                        'head' => 'Bank Charges'
                    ],
                ],
            ]
        ]
    ]
];
