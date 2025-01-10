<?php

namespace App\Domain\Exceptions\Core\Company;

use Exception;

class CompanyException extends Exception
{

    public function __construct($message = '', $code = 0, $previous = null)
    {
        $this->message = !empty($message) ? $message : 'Erro ao processar os dados da empresa.';
        $this->code = $code ? $code : 400;
        parent::__construct($this->message, $this->code, $previous);
    }
}
