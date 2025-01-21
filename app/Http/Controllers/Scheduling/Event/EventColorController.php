<?php

namespace App\Http\Controllers\Scheduling\Event;

use App\Application\Scheduling\Event\ListEventColor;
use App\Http\Controllers\Controller;
use Exception;

class EventColorController extends Controller
{
    public function __construct(
        private ListEventColor $listEventColorUseCase
    ) {}

    public function index()
    {
        try {
            $output = $this->listEventColorUseCase->execute();
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
