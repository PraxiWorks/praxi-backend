<?php

namespace App\Domain\Exceptions\Core\Permission;

use Exception;

class PermissionNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Permissao não encontrada.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}