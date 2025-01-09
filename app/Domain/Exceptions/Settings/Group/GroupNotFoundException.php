<?php

namespace App\Domain\Exceptions\Settings\Group;

use Exception;

class GroupNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Grupo não encontrado';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}
