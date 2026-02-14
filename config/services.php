<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'linkedin' => [
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
        'redirect' => env('LINKEDIN_REDIRECT_URI', '/auth/linkedin/callback'),
        'scopes' => ['openid', 'profile', 'email'],
    ],

    'evolution' => [
        'api_url' => env('EVOLUTION_API_URL', 'http://localhost:8080'),
        'api_key' => env('EVOLUTION_API_KEY'),
        'instances' => [
            'uk-police' => env('EVOLUTION_INSTANCE_UK', 'uk-5000'),
            'greece' => env('EVOLUTION_INSTANCE_GREECE', 'greece'),
            'portugal' => env('EVOLUTION_INSTANCE_PORTUGAL', 'purtugal'),
        ],
        'admin_number' => env('WHATSAPP_ADMIN_NUMBER', '306981513600'),
    ],

];
