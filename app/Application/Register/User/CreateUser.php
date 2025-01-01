<?php

namespace App\Application\Register\User;

use App\Application\Register\User\DTO\CreateUserRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Register\User\UserException;
use App\Domain\Exceptions\Settings\SettingsNotFoundException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

use App\Models\Register\User\User;
use App\Services\Image\ProcessImage;

class CreateUser
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private GroupRepositoryInterface $groupRepositoryInterface,
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

        $group = $this->groupRepositoryInterface->getById($input->getGroupId());
        if (empty($group)) {
            throw new SettingsNotFoundException('Grupo não encontrado', 400);
        }

        $pathImage = $this->processImage->execute($input->getImageBase64(), 'users', $company->name);

        $hashedPassword = password_hash($input->getPassword(), PASSWORD_DEFAULT);

        $user = User::new(
            $input->getCompanyId(),
            $input->getUsername(),
            $input->getName(),
            $input->getEmail(),
            $input->getPhoneNumber(),
            $input->getDateOfBirth(),
            $input->getCpfNumber(),
            $input->getRgNumber(),
            $input->getGender(),
            $input->getSendNotificationEmail(),
            $input->getSendNotificationSms(),
            $input->getSendNotificationWhatsapp(),
            $pathImage,
            $hashedPassword,
            $input->getIsProfessional(),
            $group->id,
            $input->getStatus()
        );

        if (!$this->userRepositoryInterface->save($user)) {
            throw new UserException('Erro ao salvar usuário', 500);
        }

        return true;
    }

    private function validateInput(CreateUserRequestDTO $input): void
    {
        if (empty($input->getUsername())) {
            throw new UserException('Nome de usuário não informado', 400);
        }

        if (empty($input->getName())) {
            throw new UserException('Nome não informado', 400);
        }

        if (empty($input->getEmail())) {
            throw new UserException('Email não informado', 400);
        }
    }
}
