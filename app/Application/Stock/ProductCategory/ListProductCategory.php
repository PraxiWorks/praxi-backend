<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;

class ListProductCategory
{
    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->productCategoryRepositoryInterface->list($input->getId());
    }
}
