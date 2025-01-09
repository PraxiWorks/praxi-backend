<?php

namespace App\Domain\Exceptions\Settings\EventProcedure;

use Exception;

class EventProcedureNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Procedimento não encontrado';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
