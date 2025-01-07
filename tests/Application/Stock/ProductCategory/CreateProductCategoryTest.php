<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\CreateProductCategory;
use App\Application\Stock\ProductCategory\DTO\CreateProductCategoryRequestDTO;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;
use Tests\TestCase;

class CreateProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;

    private CreateProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);

        $this->useCase = new CreateProductCategory(
            $this->productCategoryRepositoryInterfaceMock,
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateProductCategoryRequestDTO(1, '', true);
        $this->useCase->execute($input);
    }


    public function testCategoryAlreadyExists()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Categoria já cadastrada');

        $input = new CreateProductCategoryRequestDTO(1, 'name', true);

        $productCategory = new ProductCategory();

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getByCompanyIdAndName')->willReturn($productCategory);

        $this->useCase->execute($input);
    }

    public function testErrorSavingProductCategory()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Erro ao salvar o categoria');

        $input = new CreateProductCategoryRequestDTO(1, 'name', true);

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getByCompanyIdAndName')->willReturn(null);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateProductCategoryRequestDTO(1, 'name', true);

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getByCompanyIdAndName')->willReturn(null);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
