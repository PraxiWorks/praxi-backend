<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\ListEventStatus;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use Tests\TestCase;

class ListEventStatusTest extends TestCase
{
    private EventStatusRepositoryInterface $eventStatusRepositoryInterfaceMock;

    private ListEventStatus $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventStatusRepositoryInterfaceMock = $this->createMock(EventStatusRepositoryInterface::class);

        $this->useCase = new ListEventStatus(
            $this->eventStatusRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedEventRecurrenceList()
    {
        // Define o valor de retorno esperado do método list
        $eventRecurrence = $this->eventRecurrenceMock();

        $input = new IdRequestDTO(1);
        $this->eventStatusRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($eventRecurrence);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($eventRecurrence, $result);
    }

    public function eventRecurrenceMock()
    {
        return [
            [
                "id" => 1,
                "name" => "Example Color",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ]
        ];
    }
}
