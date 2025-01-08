<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\ShowEvent;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Scheduling\Event;
use Tests\TestCase;

class ShowEventTest extends TestCase
{
    private EventRepositoryInterface $eventRepositoryInterfaceMock;

    private ShowEvent $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);

        $this->useCase = new ShowEvent(
            $this->eventRepositoryInterfaceMock
        );
    }

    public function testEventNotFound()
    {
        $this->expectException(EventNotFoundException::class);

        $input = new IdRequestDTO(1);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedEvent()
    {
        // Define o valor de retorno esperado do método list
        $eventMock = new Event();

        $input = new IdRequestDTO(1);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventMock);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($eventMock, $result);
    }
}
