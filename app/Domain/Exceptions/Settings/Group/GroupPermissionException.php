<?php

namespace App\Domain\Exceptions\Settings\Group;

use Exception;

class GroupPermissionException extends Exception
{

    const DEFAULT_MESSAGE = 'Erro ao processar os dados';
    const DEFAULT_CODE = 400;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
