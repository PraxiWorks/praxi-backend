<?php

namespace App\Domain\Exceptions\Register\User;

use Exception;

class UserNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Usuário não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}