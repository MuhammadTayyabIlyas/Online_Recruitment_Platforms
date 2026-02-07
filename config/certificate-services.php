<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Certificate Services Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains configuration for all certificate services including
    | bank details, pricing, and service-specific information.
    |
    */

    'services' => [
        'uk-police' => [
            'name' => 'UK Police Character Certificate',
            'short_name' => 'UK Police Certificate',
            'reference_prefix' => 'PCC',
            'brand_color' => '#4F46E5', // Indigo
            'processing_times' => [
                'normal' => '14 working days',
                'urgent' => '7 working days',
            ],
            'pricing' => [
                'gbp' => [
                    'normal' => 125,
                    'urgent' => 175,
                    'currency_symbol' => '£',
                    'currency_code' => 'GBP',
                ],
                'eur' => [
                    'normal' => 150,
                    'urgent' => 200,
                    'currency_symbol' => '€',
                    'currency_code' => 'EUR',
                ],
            ],
            'bank_accounts' => [
                'gbp' => [
                    'bank_name' => 'Wise',
                    'account_name' => 'PLACEMENET I.K.E.',
                    'account_number' => '21126413',
                    'sort_code' => '23-08-01',
                    'iban' => 'GB52 TRWI 2308 0121 1264 13',
                    'swift_bic' => 'TRWIGB2LXXX',
                ],
                'eur' => [
                    'bank_name' => 'Wise',
                    'account_name' => 'PLACEMENET I.K.E.',
                    'iban' => 'BE10 9677 3176 2104',
                    'swift_bic' => 'TRWIBEB1XXX',
                ],
            ],
        ],

        'portugal' => [
            'name' => 'Portugal Criminal Record Certificate',
            'short_name' => 'Portugal Certificate',
            'reference_prefix' => 'PRT',
            'brand_color' => '#059669', // Emerald
            'processing_times' => [
                'normal' => 'Up to 30 days',
                'urgent' => '14 days',
            ],
            'pricing' => [
                'eur' => [
                    'normal' => 200,
                    'urgent' => 250,
                    'currency_symbol' => '€',
                    'currency_code' => 'EUR',
                ],
            ],
            'bank_accounts' => [
                'eur' => [
                    'bank_name' => 'Wise',
                    'account_name' => 'PLACEMENET I.K.E.',
                    'iban' => 'BE10 9677 3176 2104',
                    'swift_bic' => 'TRWIBEB1XXX',
                ],
            ],
        ],

        'greece' => [
            'name' => 'Greece Penal Record Certificate',
            'short_name' => 'Greece Certificate',
            'reference_prefix' => 'GRC',
            'brand_color' => '#D97706', // Amber
            'processing_times' => [
                'normal' => 'Up to 30 days',
                'urgent' => '15-20 days',
            ],
            'pricing' => [
                'eur' => [
                    'normal' => 250,
                    'urgent' => 350,
                    'currency_symbol' => '€',
                    'currency_code' => 'EUR',
                ],
            ],
            'bank_accounts' => [
                'eur' => [
                    'bank_name' => 'Wise',
                    'account_name' => 'PLACEMENET I.K.E.',
                    'iban' => 'BE10 9677 3176 2104',
                    'swift_bic' => 'TRWIBEB1XXX',
                ],
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Company Contact Information
    |--------------------------------------------------------------------------
    */
    'company' => [
        'name' => 'PlaceMeNet',
        'legal_name' => 'PLACEMENET I.K.E.',
        'email' => 'info@placemenet.com',
        'support_email' => 'support@placemenet.net',
        'whatsapp' => '+34 639 444 410',
        'whatsapp_spain' => '+34 639 444 410',
        'website' => 'https://placemenet.com',
    ],
];
