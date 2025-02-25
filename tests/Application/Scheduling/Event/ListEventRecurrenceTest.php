<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\ListEventRecurrence;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use Tests\TestCase;

class ListEventRecurrenceTest extends TestCase
{
    private EventRecurrenceRepositoryInterface $eventRecurrenceRepositoryInterfaceMock;

    private ListEventRecurrence $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRecurrenceRepositoryInterfaceMock = $this->createMock(EventRecurrenceRepositoryInterface::class);

        $this->useCase = new ListEventRecurrence(
            $this->eventRecurrenceRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedEventRecurrenceList()
    {
        // Define o valor de retorno esperado do método list
        $eventRecurrence = $this->eventRecurrenceMock();

        $input = new IdRequestDTO(1);
        $this->eventRecurrenceRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($eventRecurrence);

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
