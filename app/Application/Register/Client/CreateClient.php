<?php

namespace App\Application\Register\Client;

use App\Application\Register\Client\DTO\CreateClientRequestDTO;
use App\Domain\Exceptions\Company\CompanyException;
use App\Domain\Exceptions\Register\Client\ClientException;
use App\Domain\Exceptions\Settings\SettingsException;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Client\ClientRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Core\Permission\GroupPermission;
use App\Models\Register\Client\Client;
use App\Models\Register\Group\Group;
use App\Services\Image\ProcessImage;
use Exception;
use Illuminate\Support\Facades\DB;

class CreateClient
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private ClientRepositoryInterface $clientRepositoryInterface,
        private GroupRepositoryInterface $groupRepositoryInterface,
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
        private ProcessImage $processImage,
    ) {}

    public function execute(CreateClientRequestDTO $input): bool
    {
        $this->validateInput($input);
        DB::beginTransaction();
        try {
            $company = $this->getCompany($input);
            $group = $this->createGroup($company);
            $pathImage = $this->processImage->execute($input->getImageBase64(), 'users', $company->name);
            $hashedPassword = password_hash($input->getPassword(), PASSWORD_DEFAULT);
            $this->createClient($input, $company, $group, $pathImage, $hashedPassword);

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function validateInput(CreateClientRequestDTO $input): void
    {
        $requiredFields = [
            'Nome' => $input->getName(),
            'Email' => $input->getEmail(),
            'Senha' => $input->getPassword()
        ];

        foreach ($requiredFields as $field => $value) {
            if (empty($value)) {
                throw new ClientException("{$field} é obrigatório", 400);
            }
        }
    }

    private function getCompany(CreateClientRequestDTO $input): Company
    {
        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        if (empty($company)) {
            throw new CompanyException('Empresa não encontrada', 400);
        }

        return $company;
    }


    private function createGroup(Company $company): Group
    {
        $group = $this->groupRepositoryInterface->findByNameAndCompanyId($company->id, 'Cliente');
        if (!empty($group)) {
            return $group;
        }

        $group = Group::new($company->id, 'Cliente', true);

        if (!$this->groupRepositoryInterface->save($group)) {
            throw new SettingsException('Erro ao criar o grupo', 500);
        };

        $this->assignPermissionsToGroup($group);

        return $group;
    }

    private function assignPermissionsToGroup(Group $group): void
    {
        $permissions = $this->permissionRepositoryInterface->getPermissionByAction('event');

        foreach ($permissions as $permission) {
            $groupPermission = GroupPermission::new(
                $group->id,
                $permission->id,
                false
            );

            if (!$this->groupPermissionRepositoryInterface->save($groupPermission)) {
                throw new SettingsException('Erro ao atribuir permissões ao grupo', 500);
            }
        }
    }

    private function createClient(CreateClientRequestDTO $input, Company $company, Group $group, string $pathImage, string $hashedPassword): void
    {
        $client = $this->clientRepositoryInterface->getByEmailAndCompanyId($input->getEmail(), $company->id);
        if (!empty($client)) {
            throw new ClientException('Email já cadastrado', 400);
        }

        $client = Client::new(
            $input->getCompanyId(),
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
            $input->getHasAccessToTheSystem(),
            $group->id,
            $input->getStatus()
        );

        if (!$this->clientRepositoryInterface->save($client)) {
            throw new ClientException('Erro ao salvar cliente', 500);
        }
    }
}
