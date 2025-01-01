<?php

namespace App\Domain\Interfaces\Register\Group;

use App\Models\Register\Group\Group;

interface GroupRepositoryInterface
{
    public function save(Group $entity): bool;
    public function getById(int $id): ?Group;
    public function list(int $companyId): array;
    public function update(Group $entity): bool;
    public function delete(Group $entity): bool;
    public function findByNameAndCompanyId(int $company_id, string $name): ?Group;
}
