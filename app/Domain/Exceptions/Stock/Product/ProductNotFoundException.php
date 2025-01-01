<?php

namespace App\Domain\Exceptions\Stock\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Produto não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}