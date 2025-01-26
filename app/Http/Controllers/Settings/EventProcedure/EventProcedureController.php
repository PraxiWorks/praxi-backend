<?php

namespace App\Http\Controllers\Settings\EventProcedure;

use App\Application\DTO\IdRequestDTO;
use App\Application\Settings\EventProcedure\CreateEventProcedure;
use App\Application\Settings\EventProcedure\DeleteEventProcedure;
use App\Application\Settings\EventProcedure\DTO\CreateEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\DTO\UpdateEventProcedureRequestDTO;
use App\Application\Settings\EventProcedure\ListEventProcedure;
use App\Application\Settings\EventProcedure\ShowEventProcedure;
use App\Application\Settings\EventProcedure\UpdateEventProcedure;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class EventProcedureController extends Controller
{

    public function __construct(
        private CreateEventProcedure $createEventProcedureUseCase,
        private ShowEventProcedure $showEventProcedureUseCase,
        private ListEventProcedure $listEventProcedureUseCase,
        private UpdateEventProcedure $updateEventProcedureUseCase,
        private DeleteEventProcedure $deleteEventProcedureUseCase
    ) {}

    public function index(Request $request)
    {
        $companyId = $request->route('companyId');
        $status = $request->status ?? '';

        try {
            $input = new ListEventProcedureRequestDTO(
                $companyId,
                $status
            );
            $output = $this->listEventProcedureUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new CreateEventProcedureRequestDTO(
                $companyId,
                $name,
                $status
            );
            $output = $this->createEventProcedureUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function show(Request $request)
    {
        $id = $request->route('eventProcedureId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->showEventProcedureUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }


    public function update(Request $request)
    {
        $id = $request->route('eventProcedureId') ?? 0;
        $companyId = $request->route('companyId');
        $name = $request->name ?? '';
        $status = $request->status ?? false;

        try {
            $input = new UpdateEventProcedureRequestDTO(
                $id,
                $companyId,
                $name,
                $status
            );
            $output = $this->updateEventProcedureUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function delete(Request $request)
    {
        $id = $request->route('eventProcedureId') ?? 0;
        try {
            $input = new IdRequestDTO($id);
            $output = $this->deleteEventProcedureUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
