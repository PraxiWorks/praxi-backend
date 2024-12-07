<?php

namespace App\Http\Controllers\Proxy;


use App\Application\Proxy\DTO\HolidayInputDTO;
use App\Application\Proxy\HolidaysList;
use App\Http\Controllers\Controller;
use Exception;

class HolidaysController extends Controller
{
    private HolidaysList $useCase;

    public function __construct(HolidaysList $useCase)
    {
        $this->useCase = $useCase;
    }

    public function __invoke(int $month, int $year)
    {
        try {
            $input = new HolidayInputDTO($month, $year);
            $output = $this->useCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
