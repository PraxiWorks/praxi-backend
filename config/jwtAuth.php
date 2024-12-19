<?php

return [
    'secret' => env('JWT_SECRET'),
    'domain' => env('APP_URL', 'localhost'),
    'expirationTime' => env('JWT_EXPIRATION_TIME', 4),
];
