<?php

namespace App\Application\Stock\Product;

use App\Application\Stock\Product\DTO\CreateProductRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;
use App\Services\Image\ProcessImage;

class CreateProduct
{

    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ProductRepositoryInterface $productRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(CreateProductRequestDTO $input): bool
    {
        $this->validateInput($input);

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        if (empty($company)) {
            throw new CompanyException('Empresa não encontrada', 400);
        }

        $product = $this->productRepositoryInterface->getBySkuCode($input->getSkuCode());
        if(!empty($product)) {
            throw new ProductException('Produto já cadastrado', 400);
        }

        $pathImage = $this->processImage->execute($input->getImageBase64(), 'products', $company->name);

        $newProduct = Product::new(
            $company->id,
            $input->getName(),
            $input->getCategoryId(),
            $input->getSkuCode(),
            $input->getPrice(),
            $pathImage,
            $input->getStatus(),
            $input->getCurrentStock(),
            $input->getMinimumStockLevel(),
            $input->getMaximumStockLevel()
        );

        if (!$this->productRepositoryInterface->save($newProduct)) {
            throw new ProductException('Erro ao salvar o produto', 500);
        }

        return true;
    }

    private function validateInput(CreateProductRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new ProductException('Nome não informado', 400);
        }

        if (empty($input->getSkuCode())) {
            throw new ProductException('Código SKU não informado', 400);
        }
    }
}
