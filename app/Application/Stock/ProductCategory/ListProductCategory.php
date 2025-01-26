<?php

namespace App\Application\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\ListProductCategoryRequestDTO;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;

class ListProductCategory
{
    public function __construct(
        private ProductCategoryRepositoryInterface $productCategoryRepositoryInterface
    ) {}

    public function execute(ListProductCategoryRequestDTO $input): array
    {
        return $this->productCategoryRepositoryInterface->list($input);
    }
}
