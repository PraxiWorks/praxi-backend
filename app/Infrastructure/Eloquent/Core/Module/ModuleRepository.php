<?php

namespace App\Infrastructure\Eloquent\Core\Module;

use App\Domain\Interfaces\Core\Module\ModuleRepositoryInterface;
use App\Models\Core\Module\Module;

class ModuleRepository implements ModuleRepositoryInterface
{
    public function save(Module $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Module
    {
        return Module::find($id);
    }

    public function list(int $companyId): array
    {
        return Module::where('company_id', $companyId)->get()->toArray();
    }

    public function update(Module $entity): bool
    {
        return $entity->save();
    }

    public function delete(Module $entity): bool
    {
        return $entity->delete();
    }
}
