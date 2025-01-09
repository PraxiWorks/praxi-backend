<?php

namespace App\Application\Settings\Group;

use App\Application\Settings\Group\DTO\UpdateGroupRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;

class UpdateGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface,
    ) {}

    public function execute(UpdateGroupRequestDTO $input): bool
    {
        $this->validateInput($input);

        if(!empty($this->groupRepositoryInterface->findByNameAndCompanyId($input->getCompanyId(), $input->getName()))){
            throw new GroupException('Já existe um grupo com esse nome', 400);
        }

        $group = $this->groupRepositoryInterface->getById($input->getId());
        if (empty($group)) {
            throw new GroupNotFoundException();
        }

        $group->name = $input->getName();
        $group->status = $input->getStatus();

        if (!$this->groupRepositoryInterface->update($group)) {
            throw new GroupException('Erro ao atualizar o grupo', 500);
        }

        return true;
    }

    private function validateInput(UpdateGroupRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new GroupException('Nome não informado', 400);
        }
    }
}
