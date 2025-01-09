<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\EventProcedure\ListEventProcedure;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use Tests\TestCase;

class ListEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;

    private ListEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);

        $this->useCase = new ListEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock
        );
    }

    public function testExecuteReturnsExpectedEventProcedureList()
    {
        // Define o valor de retorno esperado do método list
        $eventProcedure = $this->eventProcedureMock();

        $input = new IdRequestDTO(1);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($eventProcedure);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($eventProcedure, $result);
    }

    public function eventProcedureMock()
    {
        return [
            [
                "id" => 1,
                "company_id" => 1,
                "name" => "Example Procedure",
                "status" => true,
                "created_at" => "2024-12-22T22:38:44.000000Z",
                "updated_at" => "2024-12-22T22:38:44.000000Z"
            ]
        ];
    }
}
