<?php

namespace App\Domain\Exceptions\Stock\Supplier;

use Exception;

class SupplierException extends Exception
{
    const DEFAULT_MESSAGE = 'Supplier Exception';
    const DEFAULT_CODE = 400;

    public function __construct(string $message = self::DEFAULT_MESSAGE, int $code = self::DEFAULT_CODE, ?Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
