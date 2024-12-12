<?php

namespace App\Domain\Exceptions\Scheduling\ScheduleSettings;

use Exception;

class ScheduleSettingsException extends Exception
{

    public function __construct($message = '', $code = 0, $previous = null)
    {
        $this->message = !empty($message) ? $message : 'Erro ao processar os horários de trabalho.';
        $this->code = $code ? $code : 400;
        parent::__construct($this->message, $this->code, $previous);
    }
}
