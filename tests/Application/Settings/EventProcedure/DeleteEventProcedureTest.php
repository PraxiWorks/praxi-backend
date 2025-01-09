<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\EventProcedure\DeleteEventProcedure;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;
use Tests\TestCase;

class DeleteEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;

    private DeleteEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);

        $this->useCase = new DeleteEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock
        );
    }

    public function testEventProcedureNotFound()
    {
        $this->expectException(EventProcedureNotFoundException::class);
        $this->expectExceptionMessage('Procedimento não encontrado');

        $input = new IdRequestDTO(1);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorDelteEventProcedure()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Erro ao deletar procedimento');

        $input = new IdRequestDTO(1);

        $eventProcedureMock = new EventProcedure();

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventProcedureMock);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new IdRequestDTO(1);

        $eventProcedureMock = new EventProcedure();

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventProcedureMock);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('delete')->willReturn(true);

        $this->useCase->execute($input);

        $this->assertTrue(true);
    }
}
