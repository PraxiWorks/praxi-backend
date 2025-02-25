<?php

namespace Tests\Application\Stock\Product;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Stock\Product\DTO\ListProductRequestDTO;
use App\Application\Stock\Product\ListProduct;
use App\Application\Stock\Product\Mapper\ListProductMapper;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use Tests\TestCase;

class ListProductTest extends TestCase
{
    private ProductRepositoryInterface $productRepositoryInterfaceMock;
    private ListProductMapper $listProductMapperMock;

    private ListProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);
        $this->listProductMapperMock = $this->createMock(ListProductMapper::class);

        $this->useCase = new ListProduct(
            $this->productRepositoryInterfaceMock,
            $this->listProductMapperMock
        );
    }

    public function testExecuteReturnsExpectedUserList()
    {
        // Define o valor de retorno esperado do método list
        $products = $this->productsMock();
        $outputArrayDto = new OutputArrayDTO($products);

        $input = new ListProductRequestDTO(1, true);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($products);
        $this->listProductMapperMock->expects($this->once())->method('toOutputDto')->with($products)->willReturn($outputArrayDto);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($outputArrayDto, $result);
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
