<?php

namespace App\Application\Register\User;

use App\Application\DTO\IdRequestDTO;
use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\User\Mapper\ShowUserMapper;
use App\Domain\Exceptions\Register\User\UserNotFoundException;
use App\Domain\Interfaces\Register\User\UserRepositoryInterface;

class ShowUser
{

    public function __construct(
        private UserRepositoryInterface $userRepositoryInterface,
        private ShowUserMapper $showUserMapper
    ) {}

    public function execute(IdRequestDTO $input): OutputArrayDTO
    {
        $result = $this->userRepositoryInterface->getById($input->getId());
        if (empty($result)) {
            throw new UserNotFoundException('Usuário não encontrado', 404);
        }

        return  $this->showUserMapper->toOutputDto($result);
    }
}
