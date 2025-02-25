<?php

namespace Tests\Application\Scheduling\Event\Mapper;

use PHPUnit\Framework\TestCase;
use App\Application\Scheduling\Event\Mapper\ListEventMapper;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventColorRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventRecurrenceRepositoryInterface;
use App\Domain\Interfaces\Scheduling\EventStatusRepositoryInterface;
use App\Domain\Interfaces\Settings\EventProcedure\EventProcedureRepositoryInterface;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Scheduling\Event\DTO\OutputListEventDTO;
use App\Models\Register\Client\Client;
use App\Models\Register\User\User;
use App\Models\Scheduling\EventColor;
use App\Models\Scheduling\EventProcedure;
use App\Models\Scheduling\EventRecurrence;
use App\Models\Scheduling\EventStatus;

class ListEventMapperTest extends TestCase
{
    private ClientRepositoryInterface $clientRepositoryInterfaceMock;
    private UserRepositoryInterface $userRepositoryInterfaceMock;
    private EventProcedureRepositoryInterface $eventProcedureRepositoryInterfaceMock;
    private EventStatusRepositoryInterface $eventStatusRepositoryInterfaceMock;
    private EventColorRepositoryInterface $eventColorRepositoryInterfaceMock;
    private EventRecurrenceRepositoryInterface $eventRecurrenceRepositoryInterfaceMock;

    private ListEventMapper $useCase;

    protected function setUp(): void
    {
        $this->clientRepositoryInterfaceMock = $this->createMock(ClientRepositoryInterface::class);
        $this->userRepositoryInterfaceMock = $this->createMock(UserRepositoryInterface::class);
        $this->eventProcedureRepositoryInterfaceMock = $this->createMock(EventProcedureRepositoryInterface::class);
        $this->eventStatusRepositoryInterfaceMock = $this->createMock(EventStatusRepositoryInterface::class);
        $this->eventColorRepositoryInterfaceMock = $this->createMock(EventColorRepositoryInterface::class);
        $this->eventRecurrenceRepositoryInterfaceMock = $this->createMock(EventRecurrenceRepositoryInterface::class);

        $this->useCase = new ListEventMapper(
            $this->clientRepositoryInterfaceMock,
            $this->userRepositoryInterfaceMock,
            $this->eventProcedureRepositoryInterfaceMock,
            $this->eventStatusRepositoryInterfaceMock,
            $this->eventColorRepositoryInterfaceMock,
            $this->eventRecurrenceRepositoryInterfaceMock
        );
    }

    public function testToOutputDto()
    {
        $rows = [
            [
                'id' => 1,
                'event_type' => 'type1',
                'client_id' => 1,
                'professional_id' => 1,
                'event_procedure_id' => 1,
                'event_status_id' => 1,
                'event_color_id' => 1,
                'observation' => 'observation1',
                'selected_day_index' => 1,
                'date' => '2023-10-01',
                'start_event' => '08:00:00',
                'end_event' => '09:00:00',
                'event_recurrence_id' => 1,
            ]
        ];

        $client = new Client();
        $client->name = 'Client1';

        $user = new User();
        $user->name = 'User1';

        $eventProcedure = new EventProcedure();
        $eventProcedure->name = 'Procedure1';

        $eventStatus = new EventStatus();
        $eventStatus->name = 'Status1';

        $eventColor = new EventColor();
        $eventColor->hash = '#FFFFFF';

        $eventRecurrence = new EventRecurrence();
        $eventRecurrence->name = 'Recurrence1';

        $this->clientRepositoryInterfaceMock->method('getById')->willReturn($client);
        $this->userRepositoryInterfaceMock->method('getById')->willReturn($user);
        $this->eventProcedureRepositoryInterfaceMock->method('getById')->willReturn($eventProcedure);
        $this->eventStatusRepositoryInterfaceMock->method('getById')->willReturn($eventStatus);
        $this->eventColorRepositoryInterfaceMock->method('getById')->willReturn($eventColor);
        $this->eventRecurrenceRepositoryInterfaceMock->method('getById')->willReturn($eventRecurrence);

        $outputDto = $this->useCase->toOutputDto($rows);

        $expectedDto = new OutputListEventDTO(
            1,
            'type1',
            'Client1',
            'User1',
            'Procedure1',
            'Status1',
            '#FFFFFF',
            'observation1',
            1,
            '01/10/2023',
            '08:00',
            '09:00',
            'Recurrence1'
        );

        $this->assertInstanceOf(OutputArrayDTO::class, $outputDto);
        $this->assertEquals([$expectedDto->toArray()], $outputDto->toArray());
    }
}
