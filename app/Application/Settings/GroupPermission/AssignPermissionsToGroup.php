<?php

namespace App\Application\Settings\GroupPermission;

use App\Application\Settings\GroupPermission\DTO\AssignPermissionsToGroupRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Settings\Group\GroupPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Models\Settings\GroupPermission\GroupPermission;

class AssignPermissionsToGroup
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
    ) {}

    public function execute(AssignPermissionsToGroupRequestDTO $input): bool
    {
        foreach ($input->getPermissions() as $permission) {
            $permission = $this->permissionRepositoryInterface->getById($permission);
            if (!$permission) {
                throw new PermissionNotFoundException('Permissão não encontrada');
            }
            $groupPermission = GroupPermission::new(
                $input->getGroupId(),
                $permission->id
            );
            if (!$this->groupPermissionRepositoryInterface->save($groupPermission)) {
                throw new GroupPermissionException('Erro ao salvar permissão');
            }
        }

        return true;
    }
}
