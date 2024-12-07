<?php

namespace App\Domain\Service\Proxy;

interface HolidaysServiceInterface
{
    public function enviarDadosParaApi(int $month, int $year): array;
}
