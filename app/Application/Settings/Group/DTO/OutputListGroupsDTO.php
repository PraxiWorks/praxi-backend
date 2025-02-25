<?php

namespace App\Application\Settings\Group\DTO;

class OutputListGroupsDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private bool $status
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status
        ];
    }
}
