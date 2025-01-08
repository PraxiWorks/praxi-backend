<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\DeleteEvent;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Scheduling\Event;
use Tests\TestCase;

class DeleteEventTest extends TestCase
{
    private EventRepositoryInterface $eventRepositoryInterfaceMock;

    private DeleteEvent $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);

        $this->useCase = new DeleteEvent(
            $this->eventRepositoryInterfaceMock
        );
    }

    public function testEventNotFound()
    {
        $this->expectException(EventNotFoundException::class);
        $this->expectExceptionMessage('Evento não encontrado');

        $input = new IdRequestDTO(1);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteEvent()
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Erro ao deletar o evento');

        $input = new IdRequestDTO(1);

        $eventMock = new Event();

        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventMock);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $eventMock = new Event();

        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventMock);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
