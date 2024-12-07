<?php

namespace App\Domain\Exceptions\Proxy;

use Exception;

class HolidaysException extends Exception {

    public function __construct($message = '', $code = 0, $previous = null)
    {
        $this->message = !empty($message) ? $message : 'Error communicating with the holidays API.';
        $this->code = $code ? $code : 400;
        parent::__construct($this->message,$this->code,$previous);
    }

}