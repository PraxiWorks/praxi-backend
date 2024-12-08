<?php

namespace App\Http\Controllers\Proxy;


use App\Application\Proxy\DTO\HolidayInputDTO;
use App\Application\Proxy\ListHolidays;
use App\Http\Controllers\Controller;
use Exception;

class HolidaysController extends Controller
{
    private ListHolidays $useCase;

    public function __construct(ListHolidays $useCase)
    {
        $this->useCase = $useCase;
    }

    public function index(int $month, int $year)
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
