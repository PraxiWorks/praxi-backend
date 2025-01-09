<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\Scheduling\Event\CreateEvent;
use App\Application\Scheduling\Event\DTO\UpdateEventRequestDTO;
use App\Application\Scheduling\Event\UpdateEvent;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventColorNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Exceptions\Scheduling\Event\EventNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventRecurrenceNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventStatusNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventTypeNotFoundException;
use App\Domain\Exceptions\Settings\EventProcedure\EventProcedureNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use App\Models\Scheduling\Event;
use Tests\TestCase;

class UpdateEventTest extends TestCase
{
    private EventRepositoryInterface $eventRepositoryInterfaceMock;
    private EventValidatorRepositoryInterface $eventValidatorRepositoryInterfaceMock;

    private UpdateEvent $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);
        $this->eventValidatorRepositoryInterfaceMock = $this->createMock(EventValidatorRepositoryInterface::class);


        $this->useCase = new UpdateEvent(
            $this->eventRepositoryInterfaceMock,
            $this->eventValidatorRepositoryInterfaceMock
        );
    }


    public function testExecuteThrowsEventTypeNotFoundException()
    {
        $this->expectException(EventTypeNotFoundException::class);
        $this->expectExceptionMessage('Tipo não encontrado');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventTypeNotFoundException('Tipo não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsClientNotFoundException()
    {
        $this->expectException(ClientNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new ClientNotFoundException('Cliente não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsUserNotFoundException()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Profissional não encontrado');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new UserNotFoundException('Profissional não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventProcedureNotFoundException()
    {
        $this->expectException(EventProcedureNotFoundException::class);
        $this->expectExceptionMessage('Procedimento não encontrado');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventProcedureNotFoundException('Procedimento não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventStatusNotFoundException()
    {
        $this->expectException(EventStatusNotFoundException::class);
        $this->expectExceptionMessage('Status do evento não encontrado');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventStatusNotFoundException('Status do evento não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventColorNotFoundException()
    {
        $this->expectException(EventColorNotFoundException::class);
        $this->expectExceptionMessage('Cor do evento não encontrada');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventColorNotFoundException('Cor do evento não encontrada', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventRecurrenceNotFoundException()
    {
        $this->expectException(EventRecurrenceNotFoundException::class);
        $this->expectExceptionMessage('Recorrência do evento não encontrada');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventRecurrenceNotFoundException('Recorrência do evento não encontrada', 404));

        $this->useCase->execute($input);
    }

    public function testEventNotFound()
    {
        $this->expectException(EventNotFoundException::class);

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn(null);

        $this->useCase->execute($input);
    }

    public function testErrorUpdatingEvent()
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Erro ao atualizar o evento');

        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $eventMock = new Event();
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventMock);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new UpdateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $eventMock = new Event();
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('getById')->willReturn($eventMock);
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('update')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
