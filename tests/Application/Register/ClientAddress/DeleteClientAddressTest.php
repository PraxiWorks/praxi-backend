<?php

namespace Tests\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\ClientAddress\DeleteClientAddress;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressException;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;
use Tests\TestCase;

class DeleteClientAddressTest extends TestCase
{
    private ClientAddressRepositoryInterface $clientAddressRepositoryInterfaceMock;

    private DeleteClientAddress $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientAddressRepositoryInterfaceMock = $this->createMock(ClientAddressRepositoryInterface::class);

        $this->useCase = new DeleteClientAddress(
            $this->clientAddressRepositoryInterfaceMock
        );
    }

    public function testClientAddressNotFound()
    {
        $this->expectException(ClientAddressNotFoundException::class);
        $this->expectExceptionMessage('Endereço do cliente não encontrado');

        $input = new IdRequestDTO(1);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteClientAddress()
    {
        $this->expectException(ClientAddressException::class);
        $this->expectExceptionMessage('Erro ao deletar endereço do cliente');

        $clientAddressMock = new ClientAddress();

        $input = new IdRequestDTO(1);

        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientAddressMock);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $clientAddressMock = new ClientAddress();

        $input = new IdRequestDTO(1);

        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientAddressMock);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
