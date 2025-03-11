<?php

namespace App\Infrastructure\Services\Payments\Stripe\Subscription;

use App\Application\Payments\Stripe\Subscription\DTO\CreateSubscriptionRequestDTO;
use App\Domain\Interfaces\Core\Company\CompanyRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Models\Core\Company\Company;
use App\Models\Core\Company\CompanyModule;
use App\Domain\Exceptions\Signup\CreateCompanyAndAdminUserException;
use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;

class CompanyService
{
    public function __construct(
        private CompanyRepositoryInterface $companyRepositoryInterface,
        private CompanyModuleRepositoryInterface $companyModuleRepositoryInterface,
        private CompanyPlanRepositoryInterface $companyPlanRepositoryInterface,
        private ModulePermissionRepositoryInterface $modulePermissionRepositoryInterface,
        private GroupRepositoryInterface $groupRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
        private UserRepositoryInterface $userRepositoryInterface,
        private UserPermissionRepositoryInterface $userPermissionRepositoryInterface
    ) {}

    public function updateCompanyTrial(CreateSubscriptionRequestDTO $input)
    {
        $company = $this->companyRepositoryInterface->getById($input->getCompanyId());
        if (!empty($company->start_trial) && !empty($company->end_trial)) {
            $company->start_trial = null;
            $company->end_trial = null;
            $this->updateCompany($company);
            if (!empty($input->getModule())) {
                $this->vinculateCompanyToModule([1, $input->getModule()], $company);
            }
        }
    }

    private function updateCompany(Company $company)
    {
        $this->companyRepositoryInterface->update($company);
    }

    private function vinculateCompanyToModule(array $moduleIds, Company $company)
    {
        $plans = $this->companyPlanRepositoryInterface->getByCompanyId($company->id);

        if (!empty($plans)) {
            $this->companyPlanRepositoryInterface->deleteByCompanyId($company->id);
        }

        $this->companyModuleRepositoryInterface->deleteByCompanyId($company->id);

        $modulePermissions = [];
        foreach ($moduleIds as $moduleId) {
            $permissions = $this->modulePermissionRepositoryInterface->list($moduleId);
            foreach ($permissions as $permission) {
                $modulePermissions[$permission['permission_id']] = true;
            }
        }

        $groups = $this->groupRepositoryInterface->getByCompanyId($company->id);
        foreach ($groups as $group) {
            $groupPermissions = $this->groupPermissionRepositoryInterface->getByGroupId($group['id']);
            $permissionsToDelete = [];
            if (!empty($groupPermissions)) {
                foreach ($groupPermissions as $groupPermission) {
                    if (!isset($modulePermissions[$groupPermission['permission_id']])) {
                        $permissionsToDelete[] = $groupPermission['id'];
                    }
                }
                if (!empty($permissionsToDelete)) {
                    $this->groupPermissionRepositoryInterface->deleteByGroupIdAndPermissionIds($group['id'], $permissionsToDelete);
                }
            }
        }

        $users = $this->userRepositoryInterface->getByCompanyId($company->id);
        foreach ($users as $user) {
            $userPermissions = $this->userPermissionRepositoryInterface->getByUserId($user['id']);
            $permissionsToDelete = [];
            if (!empty($userPermissions)) {
                foreach ($userPermissions as $userPermission) {
                    if (!isset($modulePermissions[$userPermission['permission_id']])) {
                        $permissionsToDelete[] = $userPermission['id'];
                    }
                }
                if (!empty($permissionsToDelete)) {
                    $this->userPermissionRepositoryInterface->deleteByUserIdAndPermissionIds($user['id'], $permissionsToDelete);
                }
            }
        }

        $companyModule = CompanyModule::new($company->id, $moduleId);
        if (!$this->companyModuleRepositoryInterface->save($companyModule)) {
            throw new CreateCompanyAndAdminUserException('Erro ao salvar o módulo na empresa', 500);
        }
    }
}
