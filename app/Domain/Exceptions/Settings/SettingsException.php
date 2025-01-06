<?php

namespace App\Domain\Exceptions\Settings;

use Exception;

class SettingsException extends Exception
{

    const DEFAULT_MESSAGE = 'Erro ao processar configurações';
    const DEFAULT_CODE = 400;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
