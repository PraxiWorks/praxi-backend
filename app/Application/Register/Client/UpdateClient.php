<?php

namespace App\Application\Register\Client;

use App\Application\Register\Client\DTO\UpdateClientRequestDTO;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Register\Client\ClientNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Services\Image\ProcessImage;

class UpdateClient
{

    public function __construct(
        private ClientRepositoryInterface $clientRepositoryInterface,
        private GroupRepositoryInterface $groupRepositoryInterface,
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(UpdateClientRequestDTO $input): bool
    {
        $this->validateInput($input);

        $client = $this->clientRepositoryInterface->getById($input->getId());
        if (empty($client)) {
            throw new ClientNotFoundException('Cliente não encontrado', 400);
        }

        if (!empty($this->clientRepositoryInterface->getByEmailAndCompanyId($input->getEmail(), $input->getCompanyId()))) {
            throw new ClientException('Email já cadastrado', 400);
        }

        if (!empty($this->clientRepositoryInterface->getByCpfAndCompanyId($input->getCpfNumber(), $input->getCompanyId()))) {
            throw new ClientException('CPF já cadastrado', 400);
        }

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        $pathImage = !empty($input->getImageBase64()) ? $this->processImage->execute($input->getImageBase64(), 'users', $company->name, $input->getName(), $client->path_image) : $client->path_image;

        $client->company_id = $input->getCompanyId();
        $client->name = $input->getName();
        $client->email = $input->getEmail();
        $client->phone_number = $input->getPhoneNumber();
        $client->date_of_birth = $input->getDateOfBirth();
        $client->cpf_number = $input->getCpfNumber();
        $client->gender = $input->getGender();
        $client->send_notification_email = $input->getSendNotificationEmail();
        $client->send_notification_sms = $input->getSendNotificationSms();
        $client->send_notification_whatsapp = $input->getSendNotificationWhatsapp();
        $client->path_image = $pathImage;
        $client->has_access_to_the_system = $input->getHasAccessToTheSystem();
        $client->status = $input->getStatus();

        if (!$this->clientRepositoryInterface->update($client)) {
            throw new ClientException('Erro ao atualizar cliente', 400);
        }

        return true;
    }

    private function validateInput(UpdateClientRequestDTO $input): void
    {

        $requiredFields = [
            'Nome' => $input->getName(),
            'Email' => $input->getEmail()
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                throw new ClientException("{$field} é obrigatório", 400);
            }
        }
    }
}
