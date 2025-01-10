<?php

namespace Tests\Application\Register\ClientAddress;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\ClientAddress\ShowClientAddress;
use App\Domain\Exceptions\Register\ClientAddress\ClientAddressNotFoundException;
use App\Domain\Interfaces\Register\ClientAddress\ClientAddressRepositoryInterface;
use App\Models\Register\ClientAddress\ClientAddress;
use Tests\TestCase;

class ShowClientAddressTest extends TestCase
{
    private ClientAddressRepositoryInterface $clientAddressRepositoryInterfaceMock;

    private ShowClientAddress $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientAddressRepositoryInterfaceMock = $this->createMock(ClientAddressRepositoryInterface::class);

        $this->useCase = new ShowClientAddress(
            $this->clientAddressRepositoryInterfaceMock
        );
    }

    public function testClientAddressNotFound()
    {
        $this->expectException(ClientAddressNotFoundException::class);
        $this->expectExceptionMessage('Endereço do cliente não encontrado');

        $input = new IdRequestDTO(1);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedClientAddress()
    {
        // Define o valor de retorno esperado do método list
        $clientAddressMock = new ClientAddress();

        $input = new IdRequestDTO(1);
        $this->clientAddressRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($clientAddressMock);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($clientAddressMock, $result);
    }
}
