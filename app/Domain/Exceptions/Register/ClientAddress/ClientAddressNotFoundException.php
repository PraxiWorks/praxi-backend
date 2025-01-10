<?php

namespace App\Domain\Exceptions\Register\ClientAddress;

use Exception;

class ClientAddressNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Endereço do cliente não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}