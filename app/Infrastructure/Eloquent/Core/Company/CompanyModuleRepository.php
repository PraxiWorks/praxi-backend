<?php

namespace App\Infrastructure\Eloquent\Core\Company;

use App\Domain\Interfaces\Core\Company\CompanyModuleRepositoryInterface;
use App\Models\Core\Company\CompanyModule;

class CompanyModuleRepository implements CompanyModuleRepositoryInterface
{
    public function save(CompanyModule $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?CompanyModule
    {
        return CompanyModule::find($id);
    }

    public function list(): array
    {
        return CompanyModule::get()->toArray();
    }

    public function update(CompanyModule $entity): bool
    {
        return $entity->update();
    }
}
