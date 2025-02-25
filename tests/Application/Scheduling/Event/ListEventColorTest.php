<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\ListEventColor;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use Tests\TestCase;

class ListEventColorTest extends TestCase
{
    private EventColorRepositoryInterface $eventColorRepositoryInterfaceMock;

    private ListEventColor $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventColorRepositoryInterfaceMock = $this->createMock(EventColorRepositoryInterface::class);

        $this->useCase = new ListEventColor(
            $this->eventColorRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedEventColorList()
    {
        // Define o valor de retorno esperado do método list
        $eventColor = $this->eventColorMock();

        $input = new IdRequestDTO(1);
        $this->eventColorRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($eventColor);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($eventColor, $result);
    }

    public function eventColorMock()
    {
        return [
            [
                "id" => 1,
                "name" => "Example Color",
                "hash" => "#000000",
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ]
        ];
    }
}
