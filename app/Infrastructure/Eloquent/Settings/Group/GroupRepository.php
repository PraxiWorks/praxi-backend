<?php

namespace App\Infrastructure\Eloquent\Settings\Group;

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
