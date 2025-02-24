<?php

namespace App\Application\Settings\Group;

use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use App\Application\Settings\Group\Mapper\ListGroupsMapper;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;

class ListGroup
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface,
        private ListGroupsMapper $listGroupsMapper
    ) {}

    public function execute(ListGroupRequestDTO $input): array
    {
        $output = $this->groupRepositoryInterface->list($input);
        return $this->listGroupsMapper->toOutputDto($output)->toArray();
    }
}
