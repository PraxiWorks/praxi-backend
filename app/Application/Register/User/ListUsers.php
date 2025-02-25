<?php

namespace App\Application\Register\User;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\User\DTO\ListUserRequestDTO;
use App\Application\Register\User\Mapper\ListUsersMapper;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

class ListUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private ListUsersMapper $listUsersMapper
    ) {}

    public function execute(ListUserRequestDTO $input): OutputArrayDTO
    {
        $output = $this->userRepositoryInterface->list($input);
        return $this->listUsersMapper->toOutputDto($output);
    }
}
