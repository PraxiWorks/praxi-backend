<?php

namespace App\Application\Register\User\DTO;

class CreateUserRequestDTO
{
    private int $companyId;
    private string $username;
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
    private string $password;
    private bool $isProfessional;
    private ?int $groupId;
    private bool $status;

    public function __construct(
        int $companyId,
        string $username,
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
        string $password,
        bool $isProfessional,
        ?int $groupId,
        bool $status
    ) {
        $this->companyId = $companyId;
        $this->username = $username;
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
        $this->password = $password;
        $this->isProfessional = $isProfessional;
        $this->groupId = $groupId;
        $this->status = $status;
    }

    public function getCompanyId(): int
    {
        return $this->companyId;
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getIsProfessional(): bool
    {
        return $this->isProfessional;
    }

    public function getGroupId(): ?int
    {
        return $this->groupId;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }
}
