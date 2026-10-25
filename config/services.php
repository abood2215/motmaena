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
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'myfatoorah' => [
        // Test: https://apitest.myfatoorah.com — Kuwait live: https://api.myfatoorah.com
        'base_url' => env('MYFATOORAH_BASE_URL', 'https://apitest.myfatoorah.com'),
        'api_key' => env('MYFATOORAH_API_KEY'),
    ],

    'deema' => [
        // Sandbox: https://sandbox-api.deema.me — live: https://api.deema.me
        'base_url' => env('DEEMA_BASE_URL', 'https://sandbox-api.deema.me'),
        'api_key' => env('DEEMA_API_KEY'),
        // The secret header pair entered in the deema merchant portal (Webhook page); webhooks without it are rejected
        'webhook_header' => env('DEEMA_WEBHOOK_HEADER', 'X-Deema-Secret'),
        'webhook_secret' => env('DEEMA_WEBHOOK_SECRET'),
    ],

    // The center's internal system: paid registrations become a client file + check + invoice there,
    // and Dr. Tariq Thursday requests show up on its Dr. Tariq appointments page
    'center' => [
        'url' => env('CENTER_SYSTEM_URL'),      // https://motmaina-center.com
        'token' => env('CENTER_SYSTEM_TOKEN'),  // same value as WEBSITE_API_TOKEN in the internal system
    ],

    // Tracking IDs — each script is only added to the site when its ID is set
    'analytics' => [
        'ga4' => env('GA4_MEASUREMENT_ID'),       // G-XXXXXXXXXX
        'meta_pixel' => env('META_PIXEL_ID'),     // digits only
        'tiktok_pixel' => env('TIKTOK_PIXEL_ID'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
