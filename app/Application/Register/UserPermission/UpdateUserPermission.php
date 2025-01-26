<?php

namespace App\Application\Register\UserPermission;

use App\Application\Register\UserPermission\DTO\UpdateUserPermissionRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Register\User\Permission\UserPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Models\Register\UserPermission\UserPermission;

class UpdateUserPermission
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private UserPermissionRepositoryInterface $userPermissionRepositoryInterface,
    ) {}

    public function execute(UpdateUserPermissionRequestDTO $input): bool
    {

        $currentPermissionIds = $this->userPermissionRepositoryInterface->getPermissionIdsByUserId($input->getUserId());

        $permissionsToAdd = array_diff($input->getPermissions(), $currentPermissionIds);

        $permissionsToRemove = array_diff($currentPermissionIds, $input->getPermissions());

        // Remover permissões que não estão no novo array
        if (!empty($permissionsToRemove)) {
            $this->userPermissionRepositoryInterface->deleteByUserIdAndPermissionIds($input->getUserId(), $permissionsToRemove);
        }

        // Adicionar permissões que não estão nas atuais
        if (!empty($permissionsToAdd)) {
            foreach ($permissionsToAdd as $permission) {
                $permission = $this->permissionRepositoryInterface->getById($permission);
                if (!$permission) {
                    throw new PermissionNotFoundException('Permissão não encontrada');
                }

                $userPermission = UserPermission::new(
                    $input->getUserId(),
                    $permission->id
                );

                if (!$this->userPermissionRepositoryInterface->save($userPermission)) {
                    throw new UserPermissionException('Erro ao salvar permissão');
                }
            }
        }

        return true;
    }
}
