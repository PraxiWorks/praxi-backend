<?php

namespace App\Domain\Exceptions\User;

use Exception;

class UserNotFoundException extends Exception
{
    public function __construct($message = "Usuário não encontrado.", $code = 404)
    {
        parent::__construct($message, $code);
    }
}