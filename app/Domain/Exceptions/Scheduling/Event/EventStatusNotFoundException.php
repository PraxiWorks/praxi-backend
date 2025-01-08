<?php

namespace App\Domain\Exceptions\Scheduling\Event;

use Exception;

class EventStatusNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Status não encontrado';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
