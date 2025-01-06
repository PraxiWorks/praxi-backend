<?php

namespace App\Application\Register\Client\DTO;

class UpdateClientRequestDTO
{
    private int $id;
    private int $companyId;
    private string $name;
    private string $email;
    private ?string $phoneNumber;
    private ?string $dateOfBirth;
    private ?string $cpfNumber;
    private ?string $rgNumber;
    private ?string $gender;
    private ?bool $sendNotificationEmail;
    private ?bool $sendNotificationSms;
    private ?bool $sendNotificationWhatsapp;
    private ?string $imageBase64;
    private bool $hasAccessToTheSystem;
    private bool $status;

    public function __construct(
        int $id,
        int $companyId,
        string $name,
        string $email,
        ?string $phoneNumber,
        ?string $dateOfBirth,
        ?string $cpfNumber,
        ?string $rgNumber,
        ?string $gender,
        ?bool $sendNotificationEmail,
        ?bool $sendNotificationSms,
        ?bool $sendNotificationWhatsapp,
        ?string $imageBase64,
        bool $hasAccessToTheSystem,
        bool $status
    ) {
        $this->id = $id;
        $this->companyId = $companyId;
        $this->name = $name;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->dateOfBirth = $dateOfBirth;
        $this->cpfNumber = $cpfNumber;
        $this->rgNumber = $rgNumber;
        $this->gender = $gender;
        $this->sendNotificationEmail = $sendNotificationEmail;
        $this->sendNotificationSms = $sendNotificationSms;
        $this->sendNotificationWhatsapp = $sendNotificationWhatsapp;
        $this->imageBase64 = $imageBase64;
        $this->hasAccessToTheSystem = $hasAccessToTheSystem;
        $this->status = $status;
    }

    public function getId(): int
    {
        return $this->id;
    }

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

    public function getRgNumber(): ?string
    {
        return $this->rgNumber;
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

    public function getHasAccessToTheSystem(): bool
    {
        return $this->hasAccessToTheSystem;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
