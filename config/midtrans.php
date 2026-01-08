<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Midtrans Configuration
    |--------------------------------------------------------------------------
    |
    | Midtrans payment gateway configuration for MAMA3RAJO E-commerce
    |
    */

    // Merchant ID
    'merchant_id' => env('MIDTRANS_MERCHANT_ID', ''),

    // Client Key (for Snap)
    'client_key' => env('MIDTRANS_CLIENT_KEY', ''),

    // Server Key (for backend)
    'server_key' => env('MIDTRANS_SERVER_KEY', ''),

    // Environment: true for production, false for sandbox
    'is_production' => env('MIDTRANS_IS_PRODUCTION', false),

    // Enable 3D Secure
    'is_3ds' => env('MIDTRANS_IS_3DS', true),

    // Sanitize: true to sanitize data sent to Midtrans
    'is_sanitized' => true,

    // Enable/Disable pending redirect
    'enable_pending_redirect' => true,
];
