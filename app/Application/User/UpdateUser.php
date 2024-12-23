<?php

namespace App\Application\User;

use App\Application\User\DTO\UpdateUserRequestDTO;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserNotFoundException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Services\Image\ProcessImage;

class UpdateUser
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(UpdateUserRequestDTO $input): bool
    {
        $this->validateInput($input);

        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserNotFoundException('Usuário não encontrado', 400);
        }

        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        $pathImage = $this->processImage->execute($input->getImageBase64(), 'users', $company->name, $user->path_image);

        $user->company_id = $input->getCompanyId();
        $user->username = $input->getUsername();
        $user->name = $input->getName();
        $user->email = $input->getEmail();
        $user->phone_number = $input->getPhoneNumber();
        $user->user_type_id = $input->getUserTypeId();
        $user->date_of_birth = $input->getDateOfBirth();
        $user->cpf_number = $input->getCpfNumber();
        $user->rg_number = $input->getRgNumber();
        $user->gender = $input->getGender();
        $user->send_notification_email = $input->getSendNotificationEmail();
        $user->send_notification_sms = $input->getSendNotificationSms();
        $user->send_notification_whatsapp = $input->getSendNotificationWhatsapp();
        $user->path_image = $pathImage;
        $user->status = $input->getStatus();

        if (!$this->userRepositoryInterface->update($user)) {
            throw new UserException('Erro ao atualizar usuário', 400);
        }

        return true;
    }

    private function validateInput(UpdateUserRequestDTO $input): void
    {
        if(empty($input->getUsername())){
            throw new UserException('Nome de usuário não informado', 400);
        }

        if (empty($input->getName())) {
            throw new UserException('Nome não informado', 400);
        }

        if (empty($input->getEmail())) {
            throw new UserException('Email não informado', 400);
        }

        if (empty($input->getUserTypeId())) {
            throw new UserException('Tipo de usuário não informado', 400);
        }
    }
}
