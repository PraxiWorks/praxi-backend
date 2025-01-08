<?php

namespace App\Http\Controllers\Scheduling\Event;

use App\Application\DTO\IdRequestDTO;
use App\Application\Scheduling\Event\CreateEvent;
use App\Application\Scheduling\Event\DeleteEvent;
use App\Application\Scheduling\Event\DTO\CreateEventRequestDTO;
use App\Application\Scheduling\Event\DTO\UpdateEventRequestDTO;
use App\Application\Scheduling\Event\ListEvent;
use App\Application\Scheduling\Event\ShowEvent;
use App\Application\Scheduling\Event\UpdateEvent;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct(
        private CreateEvent $createEventUseCase,
        private ShowEvent $showEventUseCase,
        private ListEvent $listEventUseCase,
        private UpdateEvent $updateEventUseCase,
        private DeleteEvent $deleteEventUseCase
    ) {}

    public function index(Request $request)
    {
        $id = $request->route('eventId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->listEventUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->companyId ?? null;
        $eventTypeId = $request->event_type_id ?? null;
        $clientId = $request->client_id ?? null;
        $professionalId = $request->professional_id ?? null;
        $eventProcedureId = $request->event_procedure_id ?? null;
        $eventStatusId = $request->event_status_id ?? null;
        $eventColorId = $request->event_color_id ?? null;
        $observation = $request->observation ?? null;
        $day = $request->day ?? null;
        $startEvent = $request->start_event ?? null;
        $endEvent = $request->end_event ?? null;
        $eventRecurrenceId = $request->event_recurrence_id ?? null;

        try {
            $input = new CreateEventRequestDTO(
                $companyId,
                $eventTypeId,
                $clientId,
                $professionalId,
                $eventProcedureId,
                $eventStatusId,
                $eventColorId,
                $observation,
                $day,
                $startEvent,
                $endEvent,
                $eventRecurrenceId
            );
            $output = $this->createEventUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('eventId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showEventUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $id = $request->route('eventId') ?? 0;
        $companyId = $request->companyId ?? null;
        $eventTypeId = $request->event_type_id ?? null;
        $clientId = $request->client_id ?? null;
        $professionalId = $request->professional_id ?? null;
        $eventProcedureId = $request->event_procedure_id ?? null;
        $eventStatusId = $request->event_status_id ?? null;
        $eventColorId = $request->event_color_id ?? null;
        $observation = $request->observation ?? null;
        $day = $request->day ?? null;
        $startEvent = $request->start_event ?? null;
        $endEvent = $request->end_event ?? null;
        $eventRecurrenceId = $request->event_recurrence_id ?? null;

        try {
            $input = new UpdateEventRequestDTO(
                $id,
                $companyId,
                $eventTypeId,
                $clientId,
                $professionalId,
                $eventProcedureId,
                $eventStatusId,
                $eventColorId,
                $observation,
                $day,
                $startEvent,
                $endEvent,
                $eventRecurrenceId
            );
            $output = $this->updateEventUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('eventId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteEventUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
