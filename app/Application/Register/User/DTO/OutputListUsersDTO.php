<?php

namespace App\Application\Register\User\DTO;

class OutputListUsersDTO
{
    public function __construct(
        private int $id,
        private string $name,
        private string $email,
        private ?string $phoneNumber,
        private bool $status
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'status' => $this->status
        ];
    }
}
