<?php

namespace App\Domain\Exceptions\Stock\ProductCategory;

use Exception;

class ProductCategoryNotFoundException extends Exception
{
    const DEFAULT_MESSAGE = 'Categoria não encontrado.';
    const DEFAULT_CODE = 404;

    public function __construct($message = self::DEFAULT_MESSAGE, $code = self::DEFAULT_CODE)
    {
        parent::__construct($message, $code);
    }
}