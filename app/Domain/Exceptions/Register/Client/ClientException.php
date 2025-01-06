<?php

namespace App\Domain\Exceptions\Register\Client;

use Exception;

class ClientException extends Exception
{
    const DEFAULT_MESSAGE = 'Erro ao processar os dados do client.';
    const DEFAULT_CODE = 400;

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = self::DEFAULT_CODE, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}