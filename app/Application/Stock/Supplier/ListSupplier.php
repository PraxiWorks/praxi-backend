<?php

namespace App\Application\Stock\Supplier;

use App\Application\Stock\Supplier\DTO\ListSupplierRequestDTO;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;

class ListSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface
    ) {}

    public function execute(ListSupplierRequestDTO $input): array
    {
        return $this->supplierRepositoryInterface->list($input);
    }
}
