<?php

namespace App\Infrastructure\Eloquent\Settings\Group;

use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use App\Domain\Interfaces\Settings\Group\GroupRepositoryInterface;
use App\Models\Settings\Group\Group;

class GroupRepository implements GroupRepositoryInterface
{
    public function save(Group $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Group
    {
        return Group::find($id);
    }

    public function list(ListGroupRequestDTO $input): array
    {
        $query = Group::where('company_id', $input->getCompanyId());

        if (!empty($input->getStatus())) {
            $query->where('status', $input->getStatus());
        }

        $query->orderBy('id', 'desc');

        return $query->get()->toArray();
    }

    public function update(Group $entity): bool
    {
        return $entity->update();
    }

    public function delete(Group $entity): bool
    {
        return $entity->delete();
    }

    public function findByNameAndCompanyId(int $company_id, string $name): ?Group
    {
        return Group::where('company_id', $company_id)->where('name', $name)->first();
    }

    public function getByUserId(int $id): array
    {
        return Group::where('user_id', $id)->get()->toArray();
    }
}
