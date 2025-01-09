<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\EventProcedure\ShowEventProcedure;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;
use Tests\TestCase;

class ShowEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;

    private ShowEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);

        $this->useCase = new ShowEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock
        );
    }

    public function testGroupNotFound()
    {
        $this->expectException(EventProcedureNotFoundException::class);

        $input = new IdRequestDTO(1);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $result = $this->useCase->execute($input);

        $this->assertNull($result);
    }

    public function testExecuteReturnsExpectedEventProcedure()
    {
        // Define o valor de retorno esperado do método list
        $eventProcedureMock = new EventProcedure();

        $input = new IdRequestDTO(1);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventProcedureMock);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($eventProcedureMock, $result);
    }
}
