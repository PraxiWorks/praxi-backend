<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\ProductCategory\ShowProductCategory;
use App\Domain\Exceptions\Stock\ProductCategory\ProductCategoryNotFoundException;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use App\Models\Stock\ProductCategory;
use Tests\TestCase;

class ShowProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;

    private ShowProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);

        $this->useCase = new ShowProductCategory(
            $this->productCategoryRepositoryInterfaceMock
        );
    }

    public function testProductNotFound()
    {
        $this->expectException(ProductCategoryNotFoundException::class);

        $input = new IdRequestDTO(1);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedUser()
    {
        // Define o valor de retorno esperado do método list
        $productCategory = new ProductCategory();

        $input = new IdRequestDTO(1);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($productCategory);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($productCategory, $result);
    }
}
