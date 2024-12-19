<?php

namespace App\Application\Signup\DTO;

class CreateCompanyAndAdminUserRequestDTO
{
    private string $fantasyName;
    private string $name;
    private string $email;
    private string $phoneNumber;
    private string $password;
    private array $workSchedule;

    public function __construct(
        string $fantasyName,
        string $name,
        string $email,
        string $phoneNumber,
        string $password,
        array $workSchedule
    ) {
        $this->fantasyName = $fantasyName;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->password = $password;
        $this->workSchedule = $workSchedule;
    }

    public function getFantasyName(): string
    {
        return $this->fantasyName;
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
