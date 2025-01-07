<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\Stock\ProductCategory\DTO\UpdateProductCategoryRequestDTO;
use App\Application\Stock\ProductCategory\UpdateProductCategory;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;
use Tests\TestCase;

class UpdateProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;

    private UpdateProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);

        $this->useCase = new UpdateProductCategory(
            $this->productCategoryRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateProductCategoryRequestDTO(1, 1, '', true);
        $this->useCase->execute($input);
    }


    public function testProductCategoryNotFound()
    {
        $this->expectException(ProductCategoryNotFoundException::class);

        $input = new UpdateProductCategoryRequestDTO(1, 1, 'name', true);

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingProductCategory()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Erro ao atualizar a categoria');

        $input = new UpdateProductCategoryRequestDTO(1, 1, 'name', true);

        $productCategory = new ProductCategory();

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateProductCategoryRequestDTO(1, 1, 'name', true);

        $productCategory = new ProductCategory();

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
