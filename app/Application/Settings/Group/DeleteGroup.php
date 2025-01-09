<?php

namespace App\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;

class DeleteGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): bool
    {
        $group = $this->groupRepositoryInterface->getById($input->getId());
        if (empty($group)) {
            throw new GroupNotFoundException('Grupo não encontrado', 404);
        }

        if (!$this->groupRepositoryInterface->delete($group)) {
            throw new GroupException('Erro ao deletar grupo', 500);
        }

        return true;
    }
}
