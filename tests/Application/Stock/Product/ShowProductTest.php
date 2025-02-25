<?php

namespace Tests\Application\Stock\Product;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\DTO\OutputProductDTO;
use App\Application\Stock\Product\Mapper\ShowProductMapper;
use App\Application\Stock\Product\ShowProduct;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    private ProductRepositoryInterface $productRepositoryInterfaceMock;
    private ShowProductMapper $showProductMapperMock;

    private ShowProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);
        $this->showProductMapperMock = $this->createMock(ShowProductMapper::class);

        $this->useCase = new ShowProduct(
            $this->productRepositoryInterfaceMock,
            $this->showProductMapperMock
        );
    }

    public function testProductNotFound()
    {
        $this->expectException(ProductNotFoundException::class);

        $input = new IdRequestDTO(1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedUser()
    {
        // Define o valor de retorno esperado do método list
        $product = new Product();
        $outputProductDTO = new OutputProductDTO(
            1,
            'Product 1',
            1,
            'Category 1',
            'SKU-001',
            10.00,
            'path/to/image',
            'active',
            10,
            5,
            20,
            1,
            'Supplier 1'
        );

        $input = new IdRequestDTO(1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);
        $this->showProductMapperMock->expects($this->once())->method('toOutputDto')->willReturn($outputProductDTO);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($outputProductDTO, $result);
    }
}
