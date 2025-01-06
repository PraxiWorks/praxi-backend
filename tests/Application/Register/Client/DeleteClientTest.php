<?php

namespace Tests\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\Client\DeleteClient;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Models\Register\Client\Client;
use Tests\TestCase;

class DeleteClientTest extends TestCase
{
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;

    private DeleteClient $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);

        $this->useCase = new DeleteClient(
            $this->clientRepositoryInterfaceMock
        );
    }

    public function testClientNotFound()
    {
        $this->expectException(ClientNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Erro ao deletar cliente');

        $client = new Client();

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $client = new Client();

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
