<?php

namespace App\Infrastructure\Services\Proxy;

use App\Domain\Service\Proxy\HolidaysServiceInterface;

class HolidaysService implements HolidaysServiceInterface
{
    public function enviarDadosParaApi(int $month, int $year): array
    {

        $url = 'https://brasilapi.com.br/api/feriados/v1/' . $year;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($response, true);

        $filteredData = [];
        foreach ($data as $value) {
            $splitDate = explode('-', $value['date']);
            if ($splitDate[1] == ($month - 1 < 1 ? 12 : $month - 1)) {
                $filteredData['last_month'][] = [
                    'day' => (int) $splitDate[2],
                    'name' => $value['name'],
                    'month' => (int) $splitDate[1],
                ];
            }
            if ($splitDate[1] == $month) {
                $filteredData['current_month'][] = [
                    'day' => (int) $splitDate[2],
                    'name' => $value['name'],
                    'month' => (int) $splitDate[1],
                ];
            }
            if ($splitDate[1] == ($month + 1 < 13 ? $month + 1 : 1)) {
                $filteredData['next_month'][] = [
                    'day' => (int) $splitDate[2],
                    'name' => $value['name'],
                    'month' => (int) $splitDate[1],
                ];
            }
        }

        return $filteredData;
    }
}
