<?php

namespace App\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;

class ShowProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): Product
    {
        $product = $this->productRepositoryInterface->getById($input->getId());
        if (empty($product)) {
            throw new ProductNotFoundException();
        }

        return $product;
    }
}
