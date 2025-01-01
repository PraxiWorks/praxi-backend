<?php

namespace App\Domain\Interfaces\Settings\Company;

use App\Models\Settings\Company\CompanyModule;

interface CompanyModuleRepositoryInterface
{
    public function save(CompanyModule $entity): bool;
    public function getById(int $id): ?CompanyModule;
    public function list(): array;
    public function update(CompanyModule $entity): bool;
}
