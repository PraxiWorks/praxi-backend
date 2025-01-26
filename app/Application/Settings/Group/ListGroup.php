<?php

namespace App\Application\Settings\Group;

use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;

class ListGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface
    ) {}

    public function execute(ListGroupRequestDTO $input): array
    {
        return $this->groupRepositoryInterface->list($input);
    }
}
