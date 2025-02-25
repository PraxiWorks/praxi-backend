<?php

namespace App\Application\Settings\GroupPermission;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\GroupPermission\GroupPermissionRepositoryInterface;

class DeleteGroupPermission
{
    public function __construct(
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $groupPermissions = $this->groupPermissionRepositoryInterface->getByGroupId($input->getId());
        if (empty($groupPermissions)) {
            throw new GroupNotFoundException('Permição do grupo não encontrado', 404);
        }

        foreach ($groupPermissions as $groupPermission) {
            if (!$this->groupPermissionRepositoryInterface->delete($groupPermission['id'])) {
                throw new GroupException('Erro ao deletar permissão do grupo', 500);
            }
        }

        return true;
    }
}
