<?php

namespace App\Application\Proxy;

use App\Application\Proxy\DTO\HolidayRequestDTO;
use App\Domain\Service\Proxy\HolidaysServiceInterface;

class ListHolidays
{
    public function __construct(private HolidaysServiceInterface $holidaysServiceInterface) {}

    public function execute(HolidayRequestDTO $input)
    {
        $response = $this->holidaysServiceInterface->enviarDadosParaApi($input->getMonth(), $input->getYear());
        return $response;
    }
}
