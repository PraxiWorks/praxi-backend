<?php

namespace Tests\Application\User;

use App\Application\Stock\Product\CreateProduct;
use App\Application\Stock\Product\DTO\CreateProductRequestDTO;
use App\Application\Stock\Product\DTO\UpdateProductRequestDTO;
use App\Application\Stock\Product\UpdateProduct;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Company\Company;
use App\Models\Stock\Product;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class UpdateProductTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ProductRepositoryInterface $productRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private UpdateProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new UpdateProduct(
            $this->companyRepositoryInterfaceMock,
            $this->productRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateProductRequestDTO(1, 1, '', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptySkuCode()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Código SKU não informado');

        $input = new UpdateProductRequestDTO(1, 1, 'name', 1, '', 1, 'imageBase64', true, 1, 1, 1);
        $this->useCase->execute($input);
    }


    public function testProductNotFound()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado.');

        $input = new UpdateProductRequestDTO(1, 1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingProduct()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Erro ao atualizar o produto');

        $input = new UpdateProductRequestDTO(1, 1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);

        $product = new Product();

        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';

        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->productRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateProductRequestDTO(1, 1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);

        $product = new Product();

        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';

        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->productRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);
        $this->assertTrue(true);
    }
}
