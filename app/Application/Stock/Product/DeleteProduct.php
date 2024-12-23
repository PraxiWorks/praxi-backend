<?php

namespace App\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;

class DeleteProduct
{

    public function __construct(
        private ProductRepositoryInterface $productRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $product = $this->productRepositoryInterface->getById($input->getId());
        if (empty($product)) {
            throw new ProductNotFoundException('Produto não encontrado', 404);
        }

        if (!$this->productRepositoryInterface->delete($product)) {
            throw new ProductException('Erro ao deletar produto', 500);
        }

        return true;
    }
}
