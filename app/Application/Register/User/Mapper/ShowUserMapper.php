<?php

namespace App\Application\Register\User\Mapper;

use App\Application\DTO\OutputArrayDTO;
use App\Application\Register\User\DTO\OutputShowUsersDTO;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Register\User\User;

class ShowUserMapper
{

    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface
    ) {}

    public function toOutputDto(User $row)
    {
        $group = $row->group_id ? $this->groupRepositoryInterface->getById($row->group_id) : null;

        $outputDto = new OutputShowUsersDTO(
            $row->id,
            $row->username,
            $row->name,
            $row->email,
            $row->phone_number,
            $row->date_of_birth,
            $row->cpf_number,
            $row->gender,
            $row->path_image,
            $row->is_professional,
            $group ? $group->name : null,
            $row->status
        );

        return new OutputArrayDTO($outputDto->toArray());
    }
}
