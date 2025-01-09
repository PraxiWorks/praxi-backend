<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\UpdateEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\UpdateEventProcedure;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;
use Tests\TestCase;

class UpdateEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;

    private UpdateEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);

        $this->useCase = new UpdateEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new UpdateEventProcedureRequestDTO(1, 1, '', true);
        $this->useCase->execute($input);
    }

    public function testGroupAlreadyExists()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Já existe um procedimento com esse nome');

        $input = new UpdateEventProcedureRequestDTO(1, 1, 'name', 1);

        $eventProcedureMock = new EventProcedure();
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn($eventProcedureMock);

        $this->useCase->execute($input);
    }

    public function testGroupNotFound()
    {
        $this->expectException(EventProcedureNotFoundException::class);

        $input = new UpdateEventProcedureRequestDTO(1, 1, 'name', true);

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingGroup()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Erro ao atualizar o procedimento');

        $input = new UpdateEventProcedureRequestDTO(1, 1, 'name', true);

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $eventProcedureMock = new EventProcedure();
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventProcedureMock);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateEventProcedureRequestDTO(1, 1, 'name', true);

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $eventProcedureMock = new EventProcedure();
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventProcedureMock);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
