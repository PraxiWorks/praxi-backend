<?php

namespace App\Domain\Exceptions\Settings;

use Exception;

class SettingsNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Configurações não encontradas';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
