<?php

namespace Tests\Application\Register\Client;

use App\Application\DTO\IdRequestDTO;
use App\Application\Register\Client\DeleteClient;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Register\Client\Client;
use App\Models\Scheduling\Event;
use Tests\TestCase;

class DeleteClientTest extends TestCase
{
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;
    private EventRepositoryInterface $eventRepositoryInterfaceMock;

    private DeleteClient $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);

        $this->useCase = new DeleteClient(
            $this->clientRepositoryInterfaceMock,
            $this->eventRepositoryInterfaceMock
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

    public function testClietEventExists()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Cliente possui eventos cadastrados');

        $client = new Client();
        $client->id = 1;
        $eventRepositoryInterfaceMock = [
            new Event()
        ];

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn($eventRepositoryInterfaceMock);

        $this->useCase->execute($input);
    }

    public function testErrorDelteClient()
    {
        $this->expectException(ClientException::class);
        $this->expectExceptionMessage('Erro ao deletar cliente');

        $client = new Client();
        $client->id = 1;
        $eventRepositoryInterfaceMock = [];

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn($eventRepositoryInterfaceMock);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $client = new Client();
        $client->id = 1;
        $eventRepositoryInterfaceMock = [];

        $input = new IdRequestDTO(1);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($client);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getByClientId')->willReturn($eventRepositoryInterfaceMock);
        $this->clientRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
