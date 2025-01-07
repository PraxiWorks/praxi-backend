<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;

class DeleteProductCategory
{

    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $product = $this->productCategoryRepositoryInterface->getById($input->getId());
        if (empty($product)) {
            throw new ProductCategoryNotFoundException('Categoria não encontrado', 404);
        }

        if (!$this->productCategoryRepositoryInterface->delete($product)) {
            throw new ProductCategoryException('Erro ao deletar Categoria', 500);
        }

        return true;
    }
}
