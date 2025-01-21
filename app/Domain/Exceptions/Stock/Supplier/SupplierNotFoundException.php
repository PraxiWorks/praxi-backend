<?php

namespace App\Domain\Exceptions\Stock\Supplier;

use Exception;

class SupplierNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Fornecedor não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}