<?php

namespace App\Application\DTO;

class IdRequestDTO
{
    public function __construct(
        private int $id
    ) {}

    public function getId(): int
    {
        return $this->id;
    }
}
