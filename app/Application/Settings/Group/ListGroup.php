<?php

namespace App\Application\Settings\Group;

use App\Application\DTO\IdRequestDTO;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;

class ListGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface
    ) {}

    public function execute(IdRequestDTO $input): array
    {
        return $this->groupRepositoryInterface->list($input->getId());
    }
}
