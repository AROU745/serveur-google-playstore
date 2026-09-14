<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'wise' => [
        'payment_url' => env('WISE_PAYMENT_URL', 'https://wise.com/pay/me/kodjodenisa'),
    ],

    'whop' => [
        'checkout_url' => env('WHOP_CHECKOUT_URL', 'https://whop.com/checkout/plan_pXeNEKId8AsX0'),
    ],

    'online_payment' => [
        'enabled' => env('ONLINE_PAYMENT_ENABLED', false),
        'provider' => env('ONLINE_PAYMENT_PROVIDER', 'visa_iban'),
        'public_key' => env('ONLINE_PAYMENT_PUBLIC_KEY'),
        // Secret keys must NEVER be exposed to the frontend
        'secret_key' => env('ONLINE_PAYMENT_SECRET_KEY'),
    ],

    'plan' => [
        'name' => 'PLAN SERVEUR GOOGLE PLAY',
        'amount' => 1082.00,
        'currency' => 'USD',
        'duration_months' => null,
        'duration_label' => 'Indéterminée',
        'description' => 'Google Play Server Service — abonnement durée indéterminée',
    ],

    'account_owner' => [
        'name' => env('ACCOUNT_OWNER_NAME', 'Marina God Favour'),
        'label' => env('ACCOUNT_OWNER_LABEL', 'Espace personnel'),
    ],

];
