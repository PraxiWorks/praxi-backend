<?php

namespace Tests\Application\Stock\ProductCategory;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\ProductCategory\ListProductCategory;
use App\Domain\Interfaces\Stock\ProductCategory\ProductCategoryRepositoryInterface;
use Tests\TestCase;

class ListProductCategoryTest extends TestCase
{
    private ProductCategoryRepositoryInterface $productCategoryRepositoryInterfaceMock;

    private ListProductCategory $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productCategoryRepositoryInterfaceMock = $this->createMock(ProductCategoryRepositoryInterface::class);

        $this->useCase = new ListProductCategory(
            $this->productCategoryRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedUserList()
    {
        // Define o valor de retorno esperado do método list
        $productCategories = $this->productCategoriesMock();

        $input = new IdRequestDTO(1);
        $this->productCategoryRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($productCategories);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($productCategories, $result);
    }

    public function productCategoriesMock()
    {
        return [
            [
                "id" => 2,
                "company_id" => 1,
                "name" => "categoria 1",
                "status" => true,
                "created_at" => "2025-01-07T02:18:04.000000Z",
                "updated_at" => "2025-01-07T02:18:04.000000Z"
            ]
        ];
    }
}
