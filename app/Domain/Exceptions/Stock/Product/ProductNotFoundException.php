<?php

namespace App\Domain\Exceptions\Stock\Product;

use Exception;

class ProductNotFoundException extends Exception
{
    public function __construct($message = "Produto não encontrado.", $code = 404)
    {
        parent::__construct($message, $code);
    }
}