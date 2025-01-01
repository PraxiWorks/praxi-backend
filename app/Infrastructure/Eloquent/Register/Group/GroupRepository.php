<?php

namespace App\Infrastructure\Eloquent\Register\Group;

use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Models\Register\Group\Group;

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

    public function list(int $companyId): array
    {
        return Group::get()->toArray();
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
}
