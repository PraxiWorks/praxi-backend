<?php

namespace App\Domain\Exceptions\Register\ClientAddress;

use Exception;

class ClientAddressException extends Exception
{
    const DEFAULT_MESSAGE = 'Erro ao processar os dados do endereço do cliente.';
    const DEFAULT_CODE = 400;

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = self::DEFAULT_CODE, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}