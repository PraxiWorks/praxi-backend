<?php

namespace App\Application\Proxy;

use App\Application\Proxy\DTO\HolidayInputDTO;
use App\Domain\Exceptions\Proxy\HolidaysException;
use App\Domain\Service\Proxy\HolidaysServiceInterface;

class HolidaysList
{
    private HolidaysServiceInterface $holidaysServiceInterface;

    public function __construct(HolidaysServiceInterface $holidaysServiceInterface)
    {
        $this->holidaysServiceInterface = $holidaysServiceInterface;
    }

    public function execute(HolidayInputDTO $input)
    {
        if(empty($input->getMonth())) {
            throw new HolidaysException('Mês não informado');
        }

        if(empty($input->getYear())) {
            throw new HolidaysException('Ano não informado');
        }

        $response = $this->holidaysServiceInterface->enviarDadosParaApi($input->getMonth(), $input->getYear());

        if (empty($response)) {
            throw new holidaysServiceInterface();
        }

        return $response;
    }
}
