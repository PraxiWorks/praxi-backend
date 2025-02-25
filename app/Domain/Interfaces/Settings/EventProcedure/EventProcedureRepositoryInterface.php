<?php

namespace App\Domain\Interfaces\Settings\EventProcedure;

use App\Application\Settings\EventProcedure\DTO\ListEventProcedureRequestDTO;
use App\Models\Scheduling\EventProcedure;

interface EventProcedureRepositoryInterface
{
    public function save(EventProcedure $entity): bool;
    public function getById(int $id): ?EventProcedure;
    public function list(ListEventProcedureRequestDTO $input): array;
    public function update(EventProcedure $entity): bool;
    public function delete(EventProcedure $entity): bool;
    public function findByNameAndCompanyId(int $company_id, string $name): ?EventProcedure;
}
