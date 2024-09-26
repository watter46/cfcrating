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

    'x' => [    
        'client_id' => env('X_CLIENT_ID'),  
        'client_secret' => env('X_CLIENT_SECRET'),  
        'redirect' => env('APP_URL').env('X_REDIRECT_URI'),
    ],

    'google' => [    
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('GOOGLE_REDIRECT_URI'),
    ],

    'google-admin' => [    
        'client_id' => env('ADMIN_GOOGLE_CLIENT_ID'),
        'client_secret' => env('ADMIN_GOOGLE_CLIENT_SECRET'),
        'redirect' => env('APP_URL').env('ADMIN_GOOGLE_REDIRECT_URI'),
    ],
];