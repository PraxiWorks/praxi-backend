<?php

namespace App\Application\Register\UserPermission;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\UserPermission\UserPermissionRepositoryInterface;
use App\Infrastructure\Eloquent\Register\User\UserRepository;

class GetUserPermission
{
    public function __construct(
        private UserRepository $userRepositoryInterface,
        private UserPermissionRepositoryInterface $userPermissionRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        $user = $this->userRepositoryInterface->getById($input->getId());
        if (empty($user)) {
            throw new UserNotFoundException('User not found', 404);
        }

        $userPermissions = $this->userPermissionRepositoryInterface->getByUserId($input->getId());

        $permissionIds = [];
        if (!empty($userPermissions)) {
            foreach ($userPermissions as $userPermission) {
                $permissionIds[] = $userPermission['permission_id'];
            }
        }

        return $permissionIds;
    }
}
