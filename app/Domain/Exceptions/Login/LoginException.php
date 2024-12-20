<?php

namespace App\Domain\Exceptions\Login;

use Exception;

class LoginException extends Exception
{
    const DEFAULT_MESSAGE = 'Erro ao realizar login';
    const DEFAULT_CODE = 400;

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = self::DEFAULT_CODE, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
