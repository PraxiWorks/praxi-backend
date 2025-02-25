<?php

namespace App\Application\Stock\Supplier;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\Supplier\SupplierNotFoundException;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;
use App\Models\Stock\Supplier;

class ShowSupplier
{
    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): Supplier
    {
        $supplier = $this->supplierRepositoryInterface->getById($input->getId());
        if (empty($supplier)) {
            throw new SupplierNotFoundException();
        }

        return $supplier;
    }
}
