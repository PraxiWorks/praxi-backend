<?php

namespace Tests\Application\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\CreateEventProcedure;
use App\Application\Settings\EventProcedure\DTO\CreateEventProcedureRequestDTO;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureException;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Models\Scheduling\EventProcedure;

use Tests\TestCase;

class CreateEventProcedureTest extends TestCase
{
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;

    private CreateEventProcedure $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);

        $this->useCase = new CreateEventProcedure(
            $this->eventProcedureRepositoryInterfaceMock
        );
    }

    public function testValidateInputThrowsExceptionForEmptyName()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Nome não informado');

        $input = new CreateEventProcedureRequestDTO(1, '', 1);
        $this->useCase->execute($input);
    }


    public function testEventProcedureAlreadyExists()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Procedimento já cadastrado');

        $input = new CreateEventProcedureRequestDTO(1, 'name', 1);

        $eventProcedureMock = new EventProcedure();
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn($eventProcedureMock);

        $this->useCase->execute($input);
    }

    public function testErrorSavingEventProcedure()
    {
        $this->expectException(EventProcedureException::class);
        $this->expectExceptionMessage('Erro ao salvar o procedimento');

        $input = new CreateEventProcedureRequestDTO(1, 'name', 1);

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateEventProcedureRequestDTO(1, 'name', 1);

        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('findByNameAndCompanyId')->willReturn(null);
        $this->eventProcedureRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);
        $this->assertTrue($result);
    }
}
