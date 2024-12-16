<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default User Settings
    |--------------------------------------------------------------------------
    |
    | Configurações padrão relacionadas aos usuários, como a imagem de perfil
    | padrão e limites de tamanho de arquivos.
    |
    */

    'image' => [
        'default_user_image' => env('DEFAULT_USER_IMAGE', 'images/usuarios/default.png'),
        'image_user_max_size' => env('IMAGE_USER_MAX_SIZE', 2), // Tamanho em MB
    ],

];
