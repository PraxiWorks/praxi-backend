<?php

namespace Tests\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\ShowProduct;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;
use Tests\TestCase;

class ShowProductTest extends TestCase
{
    private ProductRepositoryInterface $productRepositoryInterfaceMock;

    private ShowProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);

        $this->useCase = new ShowProduct(
            $this->productRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedUser()
    {
        // Define o valor de retorno esperado do método list
        $product = new Product();

        $input = new IdRequestDTO(1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($product, $result);
    }
}
