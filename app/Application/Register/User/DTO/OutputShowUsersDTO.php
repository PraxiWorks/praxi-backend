<?php

namespace App\Application\Register\User\DTO;

class OutputShowUsersDTO
{
    public function __construct(
        private int $id,
        private string $username,
        private string $name,
        private string $email,
        private ?string $phoneNumber,
        private ?string $dateOfBirth,
        private ?string $cpfNumber,
        private ?string $gender,
        private string $pathImage,
        private bool $isProfessional,
        private ?string $group,
        private bool $status
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'name' => $this->name,
            'email' => $this->email,
            'phone_number' => $this->phoneNumber,
            'date_of_birth' => $this->dateOfBirth,
            'cpf_number' => $this->cpfNumber,
            'gender' => $this->gender,
            'path_image' => $this->pathImage,
            'is_professional' => $this->isProfessional,
            'group' => $this->group,
            'status' => $this->status
        ];
    }
}
