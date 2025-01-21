<?php

return [

    'praxi' => [
        'default_image' => 'storage/images/praxi/default_image.png',
        'image_max_size' => env('IMAGE_USER_MAX_SIZE', 2)
    ],

    'users' => [
        'default_image' => env('DEFAULT_USER_IMAGE', 'storage/images/default_user_image.png'),
        'image_max_size' => env('IMAGE_USER_MAX_SIZE', 2)
    ],

    'clients' => [
        'default_image' => env('DEFAULT_CLIENT_IMAGE', 'storage/images/default_client_image.png'),
        'image_max_size' => env('IMAGE_USER_MAX_SIZE', 2)
    ],

    'products' => [
        'default_image' => env('DEFAULT_PRODUCT_IMAGE', 'storage/images/default_product_image.png'),
        'image_max_size' => env('IMAGE_PRODUCT_MAX_SIZE', 2)
    ],

    'suppliers' => [
        'default_image' => env('DEFAULT_SUPLIER_IMAGE', 'storage/images/default_supplier_image.png'),
        'image_max_size' => env('IMAGE_SUPLIER_MAX_SIZE', 2)
    ],
];
