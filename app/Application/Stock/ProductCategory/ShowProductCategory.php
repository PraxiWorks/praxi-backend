<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;

class ShowProductCategory
{
    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): ProductCategory
    {
        $productCategory = $this->productCategoryRepositoryInterface->getById($input->getId());
        if (empty($productCategory)) {
            throw new ProductCategoryNotFoundException();
        }

        return $productCategory;
    }
}
