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
        'logo-design' => 4000000,       // Logo per brand
        'desain-stationery' => 1000000, // Stationery set (business card, letterhead)
        'website-design' => 8000000,    // Basic website design
        'kemasan-design' => 2500000,    // Packaging design
        'feed-design' => 500000,        // Social feed package
        'design-lainnya' => 750000,     // Custom / consultation
        'website' => 8000000,
        'branding' => 3500000,
        'seo' => 1200000,
        'social-media' => 600000,
        'packaging' => 2500000,
        'stationery' => 1000000,
        'illustration' => 1500000,
        'ads' => 500000,
        'ux-ui' => 7000000,
    ],
    // Verify SSL when making server-side requests to Midtrans.
    // Set to false in local sandbox if you run into cURL CA issues.
    'verify' => env('MIDTRANS_VERIFY', false),
    // Optional path to cacert.pem file. If set, Guzzle will use this file.
    'cacert' => env('MIDTRANS_CACERT', null),
];
