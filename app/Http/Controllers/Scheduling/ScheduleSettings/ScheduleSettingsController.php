<?php

namespace App\Http\Controllers\Scheduling\ScheduleSettings;

use App\Application\Scheduling\ScheduleSettings\CreateScheduleSettings;
use App\Application\Scheduling\ScheduleSettings\DTO\CreateScheduleSettingsRequestDTO;
use App\Application\Scheduling\ScheduleSettings\DTO\UpdateScheduleSettingsRequestDTO;
use App\Application\Scheduling\ScheduleSettings\ListScheduleSettings;
use App\Application\Scheduling\ScheduleSettings\UpdateScheduleSettings;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class ScheduleSettingsController extends Controller
{
    public function __construct(
        private CreateScheduleSettings $createScheduleSettingsUseCase,
        private ListScheduleSettings $listScheduleSettingsUseCase,
        private UpdateScheduleSettings $updateScheduleSettingsUseCase,
    ) {}

    public function index()
    {
        try {
            $output = $this->listScheduleSettingsUseCase->execute();
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function store(Request $request)
    {
        $companyId = $request->companyId ?? null;
        $days = $request->days ?? [];

        try {
            $input = new CreateScheduleSettingsRequestDTO($companyId, $days);
            $output = $this->createScheduleSettingsUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }

    public function update(Request $request)
    {
        $id = $request->configId ?? 0;
        $dayOfWeek = $request->day ?? '';
        $startTime = $request->start_time ?? '';
        $endTime = $request->end_time ?? '';
        $isWorkingDay = $request->is_working_day ?? false;

        try {
            $input = new UpdateScheduleSettingsRequestDTO($id, $dayOfWeek, $startTime, $endTime, $isWorkingDay);
            $output = $this->updateScheduleSettingsUseCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
