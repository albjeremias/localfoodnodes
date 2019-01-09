<?php

return [
    'stripe' => [
        'test' => [
            'secret_key' => env('STRIPE_TEST_SECRET_KEY'),
            'publicable_key' => env('STRIPE_TEST_PUBLICABLE_KEY')
        ],
        'live' => [
            'secret_key' => env('STRIPE_LIVE_SECRET_KEY'),
            'publicable_key' => env('STRIPE_LIVE_PUBLICABLE_KEY')
        ],
    ]
];
