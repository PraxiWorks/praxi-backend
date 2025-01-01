<?php

namespace App\Infrastructure\Eloquent\Settings\Company;

use App\Domain\Interfaces\Settings\Company\CompanyModuleRepositoryInterface;
use App\Models\Settings\Company\CompanyModule;

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
