<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\CreateProductCategoryRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;

class CreateProductCategory
{

    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface,
    ) {}

    public function execute(CreateProductCategoryRequestDTO $input): bool
    {
        $this->validateInput($input);

        if (!empty($this->productCategoryRepositoryInterface->getByCompanyIdAndName($input->getCompanyId(), $input->getName()))) {
            throw new ProductCategoryException('Categoria já cadastrada', 400);
        }

        $productCategory = ProductCategory::new(
            $input->getCompanyId(),
            $input->getName(),
            $input->getStatus()
        );

        if (!$this->productCategoryRepositoryInterface->save($productCategory)) {
            throw new ProductCategoryException('Erro ao salvar o categoria', 500);
        }

        return true;
    }

    private function validateInput(CreateProductCategoryRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new ProductCategoryException('Nome não informado', 400);
        }
    }
}
