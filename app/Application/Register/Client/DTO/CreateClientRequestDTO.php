<?php

namespace App\Application\Register\Client\DTO;

class CreateClientRequestDTO
{

    public function __construct(
        private int $companyId,
        private string $name,
        private string $email,
        private ?string $phoneNumber,
        private ?string $dateOfBirth,
        private ?string $cpfNumber,
        private ?string $gender,
        private ?bool $sendNotificationEmail,
        private ?bool $sendNotificationSms,
        private ?bool $sendNotificationWhatsapp,
        private ?string $imageBase64,
        private string $password,
        private bool $hasAccessToTheSystem,
        private bool $status
    ) {}

    public function getCompanyId(): int
    {
        return $this->companyId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function getDateOfBirth(): ?string
    {
        return $this->dateOfBirth;
    }

    public function getCpfNumber(): ?string
    {
        return $this->cpfNumber;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function getSendNotificationEmail(): ?bool
    {
        return $this->sendNotificationEmail;
    }

    public function getSendNotificationSms(): ?bool
    {
        return $this->sendNotificationSms;
    }

    public function getSendNotificationWhatsapp(): ?bool
    {
        return $this->sendNotificationWhatsapp;
    }

    public function getImageBase64(): ?string
    {
        return $this->imageBase64;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getHasAccessToTheSystem(): bool
    {
        return $this->hasAccessToTheSystem;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
