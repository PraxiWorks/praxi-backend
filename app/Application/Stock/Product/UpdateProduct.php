<?php

namespace App\Application\Stock\Product;

use App\Application\Stock\Product\DTO\UpdateProductRequestDTO;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Services\Image\ProcessImage;

class UpdateProduct
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ProductRepositoryInterface $productRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(UpdateProductRequestDTO $input): bool
    {
        $this->validateInput($input);

        $product = $this->productRepositoryInterface->getById($input->getProductId());
        if (empty($product)) {
            throw new ProductNotFoundException();
        }

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        $pathImage = $this->processImage->execute($input->getImageBase64(), 'products', $company->name, $product->path_image);

        $product->name = $input->getName();
        $product->category_id = $input->getCategoryId();
        $product->sku_code = $input->getSkuCode();
        $product->price = $input->getPrice();
        $product->path_image = $pathImage;
        $product->current_stock = $input->getCurrentStock();
        $product->minimum_stock_level = $input->getMinimumStockLevel();
        $product->maximum_stock_level = $input->getMaximumStockLevel();
        $product->status = $input->getStatus();

        if (!$this->productRepositoryInterface->update($product)) {
            throw new ProductException('Erro ao atualizar o produto', 500);
        }

        return true;
    }

    private function validateInput(UpdateProductRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new ProductException('Nome não informado', 400);
        }

        if (empty($input->getSkuCode())) {
            throw new ProductException('Código SKU não informado', 400);
        }
    }
}
