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

    public function getByCompanyId(int $id): array
    {
        return Group::where('company_id', $id)->get()->toArray();
    }

    public function list(ListGroupRequestDTO $input): array
    {
        $query = Group::where('company_id', $input->getCompanyId());

        if ($input->getStatus() !== null) {
            $query->where('status', $input->getStatus());
        }

        if (!empty($input->getSearchQuery())) {
            $query->where('name', 'like', '%' . $input->getSearchQuery() . '%');
        }

        $query->orderBy('id', 'desc');

        $paginatedData = $query->paginate($input->getPerPage(), ['*'], 'page', $input->getPage());
        return $paginatedData->toArray();
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
