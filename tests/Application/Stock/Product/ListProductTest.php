<?php

namespace Tests\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\ListProduct;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    private ProductRepositoryInterface $productRepositoryInterfaceMock;

    private ListProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);

        $this->useCase = new ListProduct(
            $this->productRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedUserList()
    {
        // Define o valor de retorno esperado do método list
        $products = $this->productsMock();

        $input = new IdRequestDTO(1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($products);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($products, $result);
    }

    public function productsMock()
    {
        return [
            [
                "id" => 2,
                "company_id" => 1,
                "name" => "Example Product",
                "category_id" => null,
                "sku_code" => "EX1234",
                "price" => "99.99",
                "path_image" => "images/usuarios/default.png",
                "status" => true,
                "current_stock" => "50",
                "minimum_stock_level" => "10",
                "maximum_stock_level" => "100",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ],
            [
                "id" => 3,
                "company_id" => 1,
                "name" => "Example Product",
                "category_id" => null,
                "sku_code" => "EX1234",
                "price" => "99.99",
                "path_image" => "images/usuarios/default.png",
                "status" => true,
                "current_stock" => "50",
                "minimum_stock_level" => "10",
                "maximum_stock_level" => "100",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ],
        ];
    }
}
