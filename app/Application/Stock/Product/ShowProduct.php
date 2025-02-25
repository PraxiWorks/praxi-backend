<?php

namespace App\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\DTO\OutputProductDTO;
use App\Application\Stock\Product\Mapper\ShowProductMapper;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;

class ShowProduct
{
    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface,
        private ShowProductMapper $showProductMapper
    ) {}

    public function execute(IdRequestDTO $input): OutputProductDTO
    {
        $product = $this->productRepositoryInterface->getById($input->getId());
        if (empty($product)) {
            throw new ProductNotFoundException();
        }

        return $this->showProductMapper->toOutputDto($product);
    }
}
