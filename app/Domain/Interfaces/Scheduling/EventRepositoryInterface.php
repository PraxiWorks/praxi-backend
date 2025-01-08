<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Models\Scheduling\Event;

interface EventRepositoryInterface
{
    public function save(Event $entity): bool;
    public function getById(int $id): ?Event;
    public function list(): array;
    public function update(Event $entity): bool;
    public function delete(Event $entity): bool;
}
