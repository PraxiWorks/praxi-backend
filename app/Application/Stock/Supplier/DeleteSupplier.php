<?php

namespace App\Application\Stock\Supplier;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\Supplier\SupplierException;
use App\Domain\Exceptions\Stock\Supplier\SupplierNotFoundException;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;

class DeleteSupplier
{

    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $supplier = $this->supplierRepositoryInterface->getById($input->getId());
        if (empty($supplier)) {
            throw new SupplierNotFoundException('Fornecedor não encontrado', 404);
        }

        if (!$this->supplierRepositoryInterface->delete($supplier)) {
            throw new SupplierException('Erro ao deletar Fornecedor', 500);
        }

        return true;
    }
}
