<?php

namespace App\Domain\Exceptions\Scheduling\Event;

use Exception;

class EventRecurrenceNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Recorrência não encontrada';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
