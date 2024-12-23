<?php

namespace App\Application\User;

use App\Application\User\DTO\CreateUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\User\UserException;
use App\Domain\Exceptions\User\UserTypeNotFoundException;
use App\Domain\Interfaces\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\User\UserRepositoryInterface;
use App\Domain\Interfaces\User\UserTypeRepositoryInterface;
use App\Models\User\User;
use App\Services\Image\ProcessImage;

class CreateUser
{
    
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private UserTypeRepositoryInterface $userTypeRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(CreateUserRequestDTO $input): bool
    {

        $this->validateInput($input);


        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        if (empty($company)) {
            throw new CompanyException('Empresa não encontrada', 400);
        }

        $user = $this->userRepositoryInterface->getByEmailAndCompanyId($input->getEmail(), $company->id);
        if (!empty($user)) {
            throw new UserException('Email já cadastrado', 400);
        }

        $userType = $this->userTypeRepositoryInterface->getById($input->getUserTypeId());
        if (empty($userType)) {
            throw new UserTypeNotFoundException('Tipo de usuário não encontrado', 400);
        }

        $pathImage = $this->processImage->execute($input->getImageBase64(), 'users', $company->name);

        $hashedPassword = password_hash($input->getPassword(), PASSWORD_DEFAULT);

        $user = User::new(
            $input->getCompanyId(),
            $input->getUsername(),
            $input->getName(),
            $input->getEmail(),
            $input->getPhoneNumber(),
            $input->getUserTypeId(),
            $input->getDateOfBirth(),
            $input->getCpfNumber(),
            $input->getRgNumber(),
            $input->getGender(),
            $input->getSendNotificationEmail(),
            $input->getSendNotificationSms(),
            $input->getSendNotificationWhatsapp(),
            $pathImage,
            $hashedPassword,
            $input->getStatus()
        );

        if (!$this->userRepositoryInterface->save($user)) {
            throw new UserException('Erro ao salvar usuário', 500);
        }

        return true;
    }

    private function validateInput(CreateUserRequestDTO $input): void
    {
        if(empty($input->getUsername())) {
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
