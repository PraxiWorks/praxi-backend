<?php

namespace App\Application\Settings\Permission;

use App\Application\DTO\IdRequestDTO;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Settings\Permission\Mapper\ListPermissionMapper;
use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Company\CompanyPlanRepositoryInterface;
use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\ModulePermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Core\Plan\PlanModuleRepositoryInterface;
use Exception;
use Illuminate\Support\Collection;

class ListPermission
{
    public function __construct(
        private CompanyPlanRepositoryInterface $companyPlanRepositoryInterface,
        private CompanyModuleRepositoryInterface $companyModuleRepositoryInterface,
        private PlanModuleRepositoryInterface $planModuleRepositoryInterface,
        private ModulePermissionRepositoryInterface $modulePermissionRepositoryInterface,
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private ListPermissionMapper $listPermissionMapper
    ) {}

    public function execute(IdRequestDTO $input): OutputArrayDTO
    {
        $plan = $this->companyPlanRepositoryInterface->getByCompanyId($input->getId());
        
        $modules = $this->companyModuleRepositoryInterface->getByCompanyId($input->getId());

        $moduleIds = $this->getModuleIds($modules, $plan);

        $modulesPermission = $this->modulePermissionRepositoryInterface->getPermissionsByList($moduleIds);

        $permissionIds = [];
        foreach ($modulesPermission as $modulePermission) {
            $permissionIds[] = $modulePermission->permission_id;
        }

        $permissions = $this->permissionRepositoryInterface->getPermissionsByIds($permissionIds);

        return $this->listPermissionMapper->toOutputDto($permissions);
    }

    private function getModuleIds($modules, $plan): array
    {
        $moduleIds = [];
        if (!empty($plan)) {
            $planModules = $this->planModuleRepositoryInterface->getByPlanId($plan->id);
            foreach ($planModules as $planModule) {
                $moduleIds[] = $planModule->module_id;
            }
        }

        if (!empty($modules)) {
            foreach ($modules as $module) {
                $moduleIds[] = $module['module_id'];
            }
        }

        return array_unique($moduleIds);
    }
}
