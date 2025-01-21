<?php

namespace App\Domain\Interfaces\Scheduling;

use App\Application\Scheduling\Event\DTO\ListEventRequestDTO;
use App\Models\Scheduling\Event;

interface EventRepositoryInterface
{
    public function save(Event $entity): bool;
    public function getById(int $id): ?Event;
    public function list(ListEventRequestDTO $input): array;
    public function update(Event $entity): bool;
    public function delete(Event $entity): bool;
    public function getByClientId(int $clientId): array;
}
