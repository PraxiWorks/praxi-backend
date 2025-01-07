<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\UpdateProductCategoryRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;

class UpdateProductCategory
{
    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface,
    ) {}

    public function execute(UpdateProductCategoryRequestDTO $input): bool
    {
        $this->validateInput($input);

        $productCategory = $this->productCategoryRepositoryInterface->getById($input->getId());
        if (empty($productCategory)) {
            throw new ProductCategoryNotFoundException();
        }

        $productCategory->name = $input->getName();
        $productCategory->status = $input->getStatus();

        if (!$this->productCategoryRepositoryInterface->update($productCategory)) {
            throw new ProductCategoryException('Erro ao atualizar a categoria', 500);
        }

        return true;
    }

    private function validateInput(UpdateProductCategoryRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new ProductCategoryException('Nome não informado', 400);
        }
    }
}
