<?php

namespace Tests\Application\User;

use App\Application\Stock\Product\CreateProduct;
use App\Application\Stock\Product\DTO\CreateProductRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Stock\Product;
use App\Services\Image\ProcessImage;
use Tests\TestCase;

class CreateProductTest extends TestCase
{
    private CompanyRepositoryInterface $companyRepositoryInterfaceMock;
    private ProductRepositoryInterface $productRepositoryInterfaceMock;
    private ProcessImage $processImageMock;

    private CreateProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->companyRepositoryInterfaceMock = $this->createMock(CompanyRepositoryInterface::class);
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);
        $this->processImageMock = $this->createMock(ProcessImage::class);

        $this->useCase = new CreateProduct(
            $this->companyRepositoryInterfaceMock,
            $this->productRepositoryInterfaceMock,
            $this->processImageMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateProductRequestDTO(1, '', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        $this->useCase->execute($input);
    }

    public function testValidateInputThrowsExceptionForEmptySkuCode()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Código SKU não informado');

        $input = new CreateProductRequestDTO(1, 'name', 1, '', 1, 'imageBase64', true, 1, 1, 1);
        $this->useCase->execute($input);
    }


    public function testCompanyNotFound()
    {
        $this->expectException(CompanyException::class);
        $this->expectExceptionMessage('Empresa não encontrada');

        $input = new CreateProductRequestDTO(1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testProductAlreadyExists()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Produto já cadastrado');

        $input = new CreateProductRequestDTO(1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);

        $company = new Company();
        $company->id = 1;

        $product = new Product();

        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getBySkuCode')->willReturn($product);

        $this->useCase->execute($input);
    }

    public function testErrorSavingProduct()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Erro ao salvar o produto');

        $input = new CreateProductRequestDTO(1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        
        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';
        
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getBySkuCode')->willReturn(null);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->productRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateProductRequestDTO(1, 'name', 1, 'skuCode', 1, 'imageBase64', true, 1, 1, 1);
        
        $company = new Company();
        $company->id = 1;
        $company->name = 'companyName';
        
        $this->companyRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($company);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getBySkuCode')->willReturn(null);
        $this->processImageMock->expects($this->once())->method('execute')->willReturn('pathImage');
        $this->productRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);
        $this->assertTrue(true);
    }
}
