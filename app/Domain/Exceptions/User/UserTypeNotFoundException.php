<?php

namespace App\Domain\Exceptions\User;

use Exception;

class UserTypeNotFoundException extends Exception
{
    public function __construct($message = "Tipo de usuário não encontrado", $code = 404)
    {
        parent::__construct($message, $code);
    }
}