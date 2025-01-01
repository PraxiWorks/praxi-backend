<?php

namespace App\Domain\Interfaces\Core\Module;

use App\Models\Core\Module\Module;

interface ModuleRepositoryInterface
{
    public function save(Module $entity): bool;
    public function getById(int $id): ?Module;
    public function list(int $companyId): array;
    public function update(Module $entity): bool;
    public function delete(Module $entity): bool;
}
