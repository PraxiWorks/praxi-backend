<?php

namespace App\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;

class ListProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->productRepositoryInterface->list($input->getId());
    }
}
