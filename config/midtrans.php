<?php

return [
    // Put your Midtrans keys in .env, do NOT commit secrets to repo.
    'server_key' => env('MIDTRANS_SERVER_KEY'),
    'client_key' => env('MIDTRANS_CLIENT_KEY'),
    'merchant_id' => env('MIDTRANS_MERCHANT_ID'),
    'production' => env('MIDTRANS_PRODUCTION', false),

    // simple paket price mapping (IDR). Adjust as needed in code or extend to admin UI.
    'paket_prices' => [
        // Common package keys (legacy)
        'standard' => 100000,
        'basic' => 50000,
        'premium' => 250000,

        // Service-specific prices (IDR)
        'logo-design' => 5000000,
        'desain-stationery' => 4500000,
        'website-design' => 25000000,
        'kemasan-design' => 2500000,
        'feed-design' => 500000,
        'design-lainnya' => 750000,
        'website' => 25000000,
        'branding' => 50000000,
        'seo' => 1200000,
        'social-media' => 500000,
        'packaging' => 2500000,
        'stationery' => 4500000,
        'illustration' => 1500000,
        'ads' => 500000,
        'ux-ui' => 25000000,
    ],
    // Verify SSL when making server-side requests to Midtrans.
    // Set to false in local sandbox if you run into cURL CA issues.
    'verify' => env('MIDTRANS_VERIFY', false),
    // Optional path to cacert.pem file. If set, Guzzle will use this file.
    'cacert' => env('MIDTRANS_CACERT', null),
];
