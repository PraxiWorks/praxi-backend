<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\ProductCategory\DeleteProductCategory;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;
use Tests\TestCase;

class DeleteProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;

    private DeleteProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);

        $this->useCase = new DeleteProductCategory(
            $this->productCategoryRepositoryInterfaceMock
        );
    }

    public function testProductCategoryNotFound()
    {
        $this->expectException(ProductCategoryNotFoundException::class);
        $this->expectExceptionMessage('Categoria não encontrado');

        $input = new IdRequestDTO(1);

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteProductCategory()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Erro ao deletar Categoria');

        $input = new IdRequestDTO(1);

        $productCategory = new ProductCategory();

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $productCategory = new ProductCategory();

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
