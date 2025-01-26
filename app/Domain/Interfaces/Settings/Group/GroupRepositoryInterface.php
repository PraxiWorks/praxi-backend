<?php

namespace App\Domain\Interfaces\Settings\Group;

use App\Application\Settings\Group\DTO\ListGroupRequestDTO;
use App\Models\Settings\Group\Group;

interface GroupRepositoryInterface
{
    public function save(Group $entity): bool;
    public function getById(int $id): ?Group;
    public function list(ListGroupRequestDTO $input): array;
    public function update(Group $entity): bool;
    public function delete(Group $entity): bool;
    public function findByNameAndCompanyId(int $company_id, string $name): ?Group;
    public function getByUserId(int $id): array;
}
