<?php

namespace App\Application\Register\Client\Mapper;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\Client\DTO\OutputListClientsDTO;

class ListClientsMapper
{

    public function __construct() {}

    public function toOutputDto(array $rows)
    {
        $newlList = [
            'links' => $rows['links'] ?? [],
            'meta' => [
                'current_page' => $rows['current_page'] ?? null,
                'first_page_url' => $rows['first_page_url'] ?? null,
                'from' => $rows['from'] ?? null,
                'last_page' => $rows['last_page'] ?? null,
                'last_page_url' => $rows['last_page_url'] ?? null,
                'next_page_url' => $rows['next_page_url'] ?? null,
                'path' => $rows['path'] ?? null,
                'per_page' => $rows['per_page'] ?? null,
                'prev_page_url' => $rows['prev_page_url'] ?? null,
                'to' => $rows['to'] ?? null,
                'total' => $rows['total'] ?? null,
            ]
        ];

        $rows = $rows['data'];
        foreach ($rows as $row) {

            $outputDto = new OutputListClientsDTO(
                $row['id'],
                $row['name'],
                $row['email'],
                $row['phone_number'],
                $row['status']
            );
            $newlList['clients'][] = $outputDto->toArray();
        }

        return new OutputArrayDTO($newlList);
    }
}
