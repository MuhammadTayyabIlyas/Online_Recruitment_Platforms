<?php

return [
    'reference_prefix' => 'APT',
    'reference_length' => 8,

    'default_duration_minutes' => 30,
    'default_buffer_minutes' => 10,

    'min_cancel_hours' => 2,
    'max_advance_days' => 60,

    'auto_confirm_free' => true,
    'auto_confirm_paid' => true,

    'timezone' => 'Europe/Athens',
    'currency' => 'EUR',

    'reminders' => [
        'send_24h' => true,
        'send_1h' => true,
    ],
];
