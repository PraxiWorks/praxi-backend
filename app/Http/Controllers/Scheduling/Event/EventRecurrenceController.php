<?php

namespace App\Http\Controllers\Scheduling\Event;

use App\Application\Scheduling\Event\ListEventRecurrence;
use App\Http\Controllers\Controller;
use Exception;

class EventRecurrenceController extends Controller
{
    public function __construct(
        private ListEventRecurrence $listEventRecurrenceUseCase
    ) {}

    public function index()
    {
        try {
            $output = $this->listEventRecurrenceUseCase->execute();
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
