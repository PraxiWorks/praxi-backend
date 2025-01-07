<?php

namespace App\Application\Signup\DTO;

class CreateCompanyAndAdminUserRequestDTO
{
    public function __construct(
        private int $planId,
        private array $modules,
        private string $fantasyName,
        private string $username,
        private string $name,
        private string $email,
        private string $phoneNumber,
        private string $password,
        private array $workSchedule
    ) {}

    public function getPlanId(): int
    {
        return $this->planId;
    }

    public function getModules(): array
    {
        return $this->modules;
    }

    public function getFantasyName(): string
    {
        return $this->fantasyName;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getWorkSchedule(): array
    {
        return $this->workSchedule;
    }
}
