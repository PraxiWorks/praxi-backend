<?php

namespace App\Application\Login\DTO;

class LoginRequestDTO
{
    private int $companyId;
    private string $email;
    private string $password;

    public function __construct(int $companyId, string $email, string $password)
    {
        $this->companyId = $companyId;
        $this->email = $email;
        $this->password = $password;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
