<?php

namespace App\Application\Register\UserPermission;

use App\Application\Register\UserPermission\DTO\AssignPermissionsToUserRequestDTO;
use App\Domain\Exceptions\Core\Permission\PermissionNotFoundException;
use App\Domain\Exceptions\Register\User\Permission\UserPermissionException;
use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Models\Register\UserPermission\UserPermission;

class AssignPermissionsToUserUseCase
{
    public function __construct(
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private UserPermissionRepositoryInterface $userPermissionRepositoryInterface,
    ) {}

    public function execute(AssignPermissionsToUserRequestDTO $input): bool
    {
        foreach ($input->getPermissions() as $permission) {
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

        return true;
    }
}
