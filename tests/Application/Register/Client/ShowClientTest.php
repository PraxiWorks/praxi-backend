<?php

namespace Tests\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\Client\ShowClient;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Models\Register\Client\Client;
use Tests\TestCase;

class ShowClientTest extends TestCase
{
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;

    private ShowClient $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);

        $this->useCase = new ShowClient(
            $this->clientRepositoryInterfaceMock
        );
    }

    public function testClientNotFound()
    {
        $this->expectException(ClientNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedClient()
    {
        // Define o valor de retorno esperado do método list
        $client = new Client();

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($client, $result);
    }
}
