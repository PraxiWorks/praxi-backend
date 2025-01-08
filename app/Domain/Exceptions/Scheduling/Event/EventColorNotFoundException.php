<?php

namespace App\Domain\Exceptions\Scheduling\Event;

use Exception;

class EventColorNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Cor não encontrada';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
