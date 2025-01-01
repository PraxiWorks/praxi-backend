<?php

return [

    'praxi' => [
        'default_image' => 'images/praxi/default.png',
        'image_max_size' => env('IMAGE_USER_MAX_SIZE', 2)
    ],

    'users' => [
        'default_image' => env('DEFAULT_USER_IMAGE', 'images/usuarios/default.png'),
        'image_max_size' => env('IMAGE_USER_MAX_SIZE', 2)
    ],

    'products' => [
        'default_image' => env('DEFAULT_PRODUCT_IMAGE', 'images/estoque/default.png'),
        'image_max_size' => env('IMAGE_PRODUCT_MAX_SIZE', 2)
    ],

];
