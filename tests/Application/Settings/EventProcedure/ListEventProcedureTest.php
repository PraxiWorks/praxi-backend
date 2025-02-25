<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\ListEventProcedure;
use App\Application\Settings\EventProcedure\Mapper\ListEventProceduresMapper;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use Tests\TestCase;

class ListEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;
    private ListEventProceduresMapper $listEventProceduresMapperMock;

    private ListEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);
        $this->listEventProceduresMapperMock = $this->createMock(ListEventProceduresMapper::class);

        $this->useCase = new ListEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock,
            $this->listEventProceduresMapperMock
        );
    }

    public function testExecuteReturnsExpectedEventProcedureList()
    {
        // Define o valor de retorno esperado do método list
        $eventProcedure = $this->eventProcedureMock();
        $outputDto = new OutputArrayDTO($eventProcedure);

        $input = new ListEventProcedureRequestDTO(1, true, 'search', 1, 10, 1);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('list')->willReturn($eventProcedure);
        $this->listEventProceduresMapperMock->expects($this->once())->method('toOutputDto')->willReturn($outputDto);

        $result = $this->useCase->execute($input);

        // Verifica se o resultado é o esperado
        $this->assertEquals($outputDto, $result);
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
