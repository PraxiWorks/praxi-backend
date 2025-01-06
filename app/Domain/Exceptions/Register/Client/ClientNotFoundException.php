<?php

namespace App\Domain\Exceptions\Register\Client;

use Exception;

class ClientNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Cliente não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}