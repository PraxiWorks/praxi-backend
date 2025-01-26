<?php

namespace App\Application\Stock\Supplier;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\Supplier\SupplierException;
use App\Domain\Exceptions\Stock\Supplier\SupplierNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Domain\Interfaces\Stock\Supplier\SupplierRepositoryInterface;

class DeleteSupplier
{

    public function __construct(
        private SupplierRepositoryInterface $supplierRepositoryInterface,
        private ProductRepositoryInterface $productRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $supplier = $this->supplierRepositoryInterface->getById($input->getId());
        if (empty($supplier)) {
            throw new SupplierNotFoundException('Fornecedor não encontrado', 404);
        }

        if(!empty($this->productRepositoryInterface->getBySupplierId($supplier->id))) {
            throw new ProductCategoryException('Fornecedor não pode ser deletado, pois existem produtos vinculados a ele', 400);
        }

        if (!$this->supplierRepositoryInterface->delete($supplier)) {
            throw new SupplierException('Erro ao deletar Fornecedor', 500);
        }

        return true;
    }
}
