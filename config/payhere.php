<?php

return [
    /*
    |--------------------------------------------------------------------------
    | PayHere Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for PayHere payment gateway
    | integration. These values are loaded from your environment file.
    |
    */

    'merchant_id' => env('PAYHERE_MERCHANT_ID', '121XXXX'),
    
    'merchant_secret' => env('PAYHERE_MERCHANT_SECRET', 'your_merchant_secret'),
    
    'currency' => env('PAYHERE_CURRENCY', 'LKR'),
    
    'sandbox' => env('PAYHERE_SANDBOX', true),
    
    'urls' => [
        'sandbox' => 'https://sandbox.payhere.lk/pay/checkout',
        'production' => 'https://www.payhere.lk/pay/checkout',
    ],
    
    'callback_urls' => [
        'return' => env('APP_URL') . '/payment/success',
        'cancel' => env('APP_URL') . '/payment/cancel',
        'notify' => env('APP_URL') . '/payment/notify',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Service Charge Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the service charge percentage applied to orders
    |
    */
    
    'service_charge_rate' => env('SERVICE_CHARGE_RATE', 0.033), // 3.3%
];