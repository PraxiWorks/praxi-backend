<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\ListEvent;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use Tests\TestCase;

class ListEventTest extends TestCase
{
    private EventRepositoryInterface $eventRepositoryInterfaceMock;

    private ListEvent $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);

        $this->useCase = new ListEvent(
            $this->eventRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedEventList()
    {
        // Define o valor de retorno esperado do método list
        $events = $this->eventsMock();

        $input = new IdRequestDTO(1);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($events);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($events, $result);
    }

    public function eventsMock()
    {
        return [
            [
                "id" => 2,
                "company_id" => 1,
                "event_type_id" => 1,
                "client_id" => 1,
                "professional_id" => 3,
                "event_procedure_id" => 1,
                "event_status_id" => 1,
                "event_color_id" => 1,
                "observation" => null,
                "day" => "19-02-2002",
                "start_event" => "18:00:00",
                "end_event" => "19:00:00",
                "event_recurrence_id" => 1,
                "created_at" => "2025-01-08T19:19:38.000000Z",
                "updated_at" => "2025-01-08T19:19:38.000000Z"
            ]
        ];
    }
}
