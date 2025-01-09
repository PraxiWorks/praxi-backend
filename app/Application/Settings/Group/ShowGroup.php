<?php

namespace App\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Exceptions\Settings\Group\GroupNotFoundException;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;

class ShowGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): Group
    {
        $group = $this->groupRepositoryInterface->getById($input->getId());
        if (empty($group)) {
            throw new GroupNotFoundException();
        }

        return $group;
    }
}
