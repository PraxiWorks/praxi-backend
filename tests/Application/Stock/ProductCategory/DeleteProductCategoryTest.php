<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\ProductCategory\DeleteProductCategory;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryException;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;
use Tests\TestCase;

class DeleteProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;
    private ProductRepositoryInterface $productRepositoryInterfaceMock;

    private DeleteProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);

        $this->useCase = new DeleteProductCategory(
            $this->productCategoryRepositoryInterfaceMock,
            $this->productRepositoryInterfaceMock
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

    public function testProductCategoryCannotBeDeletedWhenProductsAreLinked()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Categoria não pode ser deletada, pois existem produtos vinculados a ela');

        $input = new IdRequestDTO(1);

        $productCategory = new ProductCategory();
        $productCategory->id = 1;

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getByCategoryId')->willReturn(['itens']);

        $this->useCase->execute($input);
    }

    public function testErrorDelteProductCategory()
    {
        $this->expectException(ProductCategoryException::class);
        $this->expectExceptionMessage('Erro ao deletar Categoria');

        $input = new IdRequestDTO(1);

        $productCategory = new ProductCategory();
        $productCategory->id = 1;

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getByCategoryId')->willReturn([]);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $productCategory = new ProductCategory();
        $productCategory->id = 1;

        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getByCategoryId')->willReturn([]);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
