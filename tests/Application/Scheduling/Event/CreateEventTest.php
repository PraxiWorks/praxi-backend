<?php

namespace Tests\Application\Scheduling\Event;

use App\Application\Scheduling\Event\CreateEvent;
use App\Application\Scheduling\Event\DTO\CreateEventRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventColorNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventException;
use App\Domain\Exceptions\Scheduling\Event\EventProcedureNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventRecurrenceNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventStatusNotFoundException;
use App\Domain\Exceptions\Scheduling\Event\EventTypeNotFoundException;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventValidatorRepositoryInterface;
use Tests\TestCase;

class CreateEventTest extends TestCase
{
    private EventRepositoryInterface $eventRepositoryInterfaceMock;
    private EventValidatorRepositoryInterface $eventValidatorRepositoryInterfaceMock;

    private CreateEvent $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->eventRepositoryInterfaceMock = $this->createMock(EventRepositoryInterface::class);
        $this->eventValidatorRepositoryInterfaceMock = $this->createMock(EventValidatorRepositoryInterface::class);


        $this->useCase = new CreateEvent(
            $this->eventRepositoryInterfaceMock,
            $this->eventValidatorRepositoryInterfaceMock
        );
    }


    public function testExecuteThrowsEventTypeNotFoundException()
    {
        $this->expectException(EventTypeNotFoundException::class);
        $this->expectExceptionMessage('Tipo não encontrado');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventTypeNotFoundException('Tipo não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsClientNotFoundException()
    {
        $this->expectException(ClientNotFoundException::class);
        $this->expectExceptionMessage('Cliente não encontrado');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new ClientNotFoundException('Cliente não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsUserNotFoundException()
    {
        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('Profissional não encontrado');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new UserNotFoundException('Profissional não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventProcedureNotFoundException()
    {
        $this->expectException(EventProcedureNotFoundException::class);
        $this->expectExceptionMessage('Procedimento não encontrado');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventProcedureNotFoundException('Procedimento não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventStatusNotFoundException()
    {
        $this->expectException(EventStatusNotFoundException::class);
        $this->expectExceptionMessage('Status do evento não encontrado');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventStatusNotFoundException('Status do evento não encontrado', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventColorNotFoundException()
    {
        $this->expectException(EventColorNotFoundException::class);
        $this->expectExceptionMessage('Cor do evento não encontrada');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventColorNotFoundException('Cor do evento não encontrada', 404));

        $this->useCase->execute($input);
    }

    public function testExecuteThrowsEventRecurrenceNotFoundException()
    {
        $this->expectException(EventRecurrenceNotFoundException::class);
        $this->expectExceptionMessage('Recorrência do evento não encontrada');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);

        $this->eventValidatorRepositoryInterfaceMock->expects($this->once())->method('validate')->willThrowException(new EventRecurrenceNotFoundException('Recorrência do evento não encontrada', 404));

        $this->useCase->execute($input);
    }


    public function testErrorSavingEvent()
    {
        $this->expectException(EventException::class);
        $this->expectExceptionMessage('Erro ao salvar evento');

        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);
        
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(false);

        $this->useCase->execute($input);
    }

    public function testSuccess()
    {
        $input = new CreateEventRequestDTO(1, 1, 1, 1, 1, 1, 1, 'observation', '2021-10-10', '10:00', '11:00', 1);
        
        $this->eventRepositoryInterfaceMock->expects($this->once())->method('save')->willReturn(true);

        $result = $this->useCase->execute($input);

        $this->assertTrue($result);
    }
}
