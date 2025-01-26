<?php

namespace App\Application\Settings\Group;

use App\Application\Settings\Group\DTO\CreateGroupRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;

class CreateGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface,
    ) {}

    public function execute(CreateGroupRequestDTO $input): Group
    {
        $this->validateInput($input);

        if (!empty($this->groupRepositoryInterface->findByNameAndCompanyId($input->getCompanyId(), $input->getName()))) {
            throw new GroupException('Grupo já cadastrado', 400);
        }

        $group = Group::new(
            $input->getCompanyId(),
            $input->getName(),
            $input->getStatus()
        );

        if (!$this->groupRepositoryInterface->save($group)) {
            throw new GroupException('Erro ao salvar o grupo', 500);
        }

        return $group;
    }

    private function validateInput(CreateGroupRequestDTO $input): void
    {
        if (empty($input->getName())) {
            throw new GroupException('Nome não informado', 400);
        }
    }
}
