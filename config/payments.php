<?php

return [
    'mercado_pago' => [
        'public_key' => env('PAYMENT_ENVIRONMENT') === 'production'
            ? env('MP_ACCESS_TOKEN')
            : env('MP_ACCESS_TOKEN_SANDBOX'),
        'access_token' => env('PAYMENT_ENVIRONMENT') === 'production'
            ? env('MP_PUBLIC_KEY')
            : env('MP_PUBLIC_KEY_SANDBOX'),
    ],
];