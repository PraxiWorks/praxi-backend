<?php

namespace App\Domain\Exceptions\Scheduling\ScheduleSettings;

use Exception;

class ScheduleSettingsException extends Exception
{

    const DEFAULT_MESSAGE = 'Erro ao processar os horários de trabalho.';
    const DEFAULT_CODE = 400;

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = self::DEFAULT_CODE, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

