<?php

return [
    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    'google' => [
        'maps' => [
            'geocoding' => env('GOOGLE_MAPS_GEOCODING'),
        ]
    ],
    'fixer' => [
        'api_access_key' => env('FIXER_API_ACCESS_KEY')
    ],
];
