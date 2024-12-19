<?php

return [
    'secret' => env('JWT_SECRET'),
    'domain' => env('APP_URL', 'localhost'),
    'timeLimit' => 8,
];
