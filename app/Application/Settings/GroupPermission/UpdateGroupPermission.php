<?php

namespace App\Application\Settings\GroupPermission;

use App\Application\Settings\GroupPermission\DTO\UpdateGroupPermissionRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Register\User\Permission\UserPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;
use App\Models\Settings\GroupPermission\GroupPermission;

class UpdateGroupPermission
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
    ) {}

    public function execute(UpdateGroupPermissionRequestDTO $input): bool
    {

        $currentPermissionIds = $this->groupPermissionRepositoryInterface->getPermissionIdsByGroupId($input->getGroupId());

        $permissionsToAdd = array_diff($input->getPermissions(), $currentPermissionIds);

        $permissionsToRemove = array_diff($currentPermissionIds, $input->getPermissions());

        // Remover permissões que não estão no novo array
        if (!empty($permissionsToRemove)) {
            $this->groupPermissionRepositoryInterface->deleteByGroupIdAndPermissionIds($input->getGroupId(), $permissionsToRemove);
        }

        // Adicionar permissões que não estão nas atuais
        if (!empty($permissionsToAdd)) {
            foreach ($permissionsToAdd as $permission) {
                $permission = $this->permissionRepositoryInterface->getById($permission);
                if (!$permission) {
                    throw new PermissionNotFoundException('Permissão não encontrada');
                }

                $groupPermission = GroupPermission::new(
                    $input->getGroupId(),
                    $permission->id
                );

                if (!$this->groupPermissionRepositoryInterface->save($groupPermission)) {
                    throw new UserPermissionException('Erro ao salvar permissão');
                }
            }
        }

        return true;
    }
}
