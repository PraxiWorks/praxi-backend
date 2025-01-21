<?php

namespace App\Http\Controllers\Scheduling\Event;

use App\Application\Scheduling\Event\ListEventStatus;
use App\Http\Controllers\Controller;
use Exception;

class EventStatusController extends Controller
{
    public function __construct(
        private ListEventStatus $listEventStatusUseCase
    ) {}

    public function index()
    {
        try {
            $output = $this->listEventStatusUseCase->execute();
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
