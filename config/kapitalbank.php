<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Kapitalbank E-Commerce API Konfiqurasiyası
    |--------------------------------------------------------------------------
    |
    | Bu konfiqurasiya Kapitalbank ödəniş sistemi ilə inteqrasiya üçün
    | lazım olan bütün parametrləri ehtiva edir.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | API Mühiti
    |--------------------------------------------------------------------------
    |
    | Test mühiti üçün: test
    | Production mühiti üçün: production
    |
    */
    'mode' => env('KAPITALBANK_MODE', 'test'),

    /*
    |--------------------------------------------------------------------------
    | API URL-ləri
    |--------------------------------------------------------------------------
    */
    'base_url' => [
        'test' => 'https://txpgtst.kapitalbank.az/api',
        'production' => 'https://e-commerce.kapitalbank.az/api',
    ],

    /*
    |--------------------------------------------------------------------------
    | HPP (Hosted Payment Page) URL-ləri
    |--------------------------------------------------------------------------
    */
    'hpp_url' => [
        'test' => 'https://txpgtst.kapitalbank.az/flex',
        'production' => 'https://e-commerce.kapitalbank.az/flex',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autentifikasiya Məlumatları (BasicAuth)
    |--------------------------------------------------------------------------
    |
    | Kapitalbank tərəfindən verilən istifadəçi adı və şifrə.
    | Test üçün: TerminalSys/kapital / kapital123
    |
    */
    'username' => env('KAPITALBANK_USERNAME', ''),
    'password' => env('KAPITALBANK_PASSWORD', ''),

    /*
    |--------------------------------------------------------------------------
    | Valyuta
    |--------------------------------------------------------------------------
    |
    | Defolt valyuta. AZN, USD, EUR və s.
    |
    */
    'currency' => env('KAPITALBANK_CURRENCY', 'AZN'),

    /*
    |--------------------------------------------------------------------------
    | Dil
    |--------------------------------------------------------------------------
    |
    | Ödəniş səhifəsinin dili: az, en, ru
    |
    */
    'language' => env('KAPITALBANK_LANGUAGE', 'az'),

    /*
    |--------------------------------------------------------------------------
    | Callback URL-ləri
    |--------------------------------------------------------------------------
    |
    | Ödəniş tamamlandıqdan sonra yönləndiriləcək URL-lər.
    |
    */
    'redirect_url' => env('KAPITALBANK_REDIRECT_URL', '/payment/callback'),
    'success_url' => env('KAPITALBANK_SUCCESS_URL', '/payment/success'),
    'error_url' => env('KAPITALBANK_ERROR_URL', '/payment/error'),

    /*
    |--------------------------------------------------------------------------
    | Kart Saxlama (Card on File)
    |--------------------------------------------------------------------------
    |
    | Müştəri kartlarını saxlamaq üçün aktivləşdirin.
    |
    */
    'save_cards' => env('KAPITALBANK_SAVE_CARDS', false),

    /*
    |--------------------------------------------------------------------------
    | Loqlama
    |--------------------------------------------------------------------------
    |
    | API sorğularını və cavablarını loglamaq üçün.
    |
    */
    'logging' => [
        'enabled' => env('KAPITALBANK_LOG_ENABLED', true),
        'channel' => env('KAPITALBANK_LOG_CHANNEL', 'stack'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Timeout
    |--------------------------------------------------------------------------
    |
    | API sorğuları üçün timeout (saniyə).
    |
    */
    'timeout' => env('KAPITALBANK_TIMEOUT', 30),

    /*
    |--------------------------------------------------------------------------
    | Sifariş Növləri
    |--------------------------------------------------------------------------
    |
    | Kapitalbank API-də istifadə olunan sifariş növləri.
    |
    */
    'order_types' => [
        'purchase' => 'Order_SMS',      // Adi alış
        'preauth' => 'Order_DMS',       // Preauthorization
        'recurring' => 'Order_REC',     // Təkrar ödəniş
        'preauth_recurring' => 'DMSN3D', // Təkrar preauth
        'card_to_card' => 'OCT',        // Kartdan karta
        'google_pay' => 'GN3D',         // Google Pay
        'google_pay_sms' => 'GSMS',     // Google Pay SMS
    ],

    /*
    |--------------------------------------------------------------------------
    | Ödəniş Statusları
    |--------------------------------------------------------------------------
    */
    'statuses' => [
        'preparing' => 'Preparing',
        'paid' => 'FullyPaid',
        'partial' => 'PartiallyPaid',
        'declined' => 'Declined',
        'refunded' => 'Refunded',
        'reversed' => 'Reversed',
        'expired' => 'Expired',
    ],
];