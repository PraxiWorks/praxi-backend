<?php

namespace App\Http\Controllers\Proxy;

use App\Application\Proxy\DTO\HolidayRequestDTO;
use App\Application\Proxy\ListHolidays;
use App\Http\Controllers\Controller;
use Exception;

class HolidaysController extends Controller
{

    public function __construct(private ListHolidays $useCase) {}

    public function index(int $month, int $year)
    {
        try {
            $input = new HolidayRequestDTO($month, $year);
            $output = $this->useCase->execute($input);
            return $this->outputSuccessArrayToJson($output, 200);
        } catch (Exception $e) {
            return $this->outputErrorArrayToJson($e->getMessage(), $e->getCode());
        }
    }
}
