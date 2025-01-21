<?php

namespace App\Application\Stock\Supplier;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;

class ListSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->supplierRepositoryInterface->list($input->getId());
    }
}
