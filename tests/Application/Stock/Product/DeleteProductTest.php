<?php

namespace Tests\Application\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\Stock\Product\DeleteProduct;
use App\Domain\Exceptions\Stock\Product\ProductException;
use App\Domain\Exceptions\Stock\Product\ProductNotFoundException;
use App\Domain\Interfaces\Stock\Product\ProductRepositoryInterface;
use App\Models\Stock\Product;
use Tests\TestCase;

class DeleteProductTest extends TestCase
{
    private ProductRepositoryInterface $productRepositoryInterfaceMock;

    private DeleteProduct $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->productRepositoryInterfaceMock = $this->createMock(ProductRepositoryInterface::class);

        $this->useCase = new DeleteProduct(
            $this->productRepositoryInterfaceMock
        );
    }

    public function testUserNotFound()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Produto não encontrado');

        $input = new IdRequestDTO(1);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteUser()
    {
        $this->expectException(ProductException::class);
        $this->expectExceptionMessage('Erro ao deletar produto');

        $input = new IdRequestDTO(1);

        $product = new Product();

        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $product = new Product();

        $this->productRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($product);
        $this->productRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
