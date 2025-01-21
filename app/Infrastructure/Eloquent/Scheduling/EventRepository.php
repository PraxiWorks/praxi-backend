<?php

namespace App\Infrastructure\Eloquent\Scheduling;

use App\Application\Scheduling\Event\DTO\ListEventRequestDTO;
use App\Domain\Interfaces\Scheduling\EventRepositoryInterface;
use App\Models\Scheduling\Event;

class EventRepository implements EventRepositoryInterface
{
    public function save(Event $entity): bool
    {
        return $entity->save();
    }

    public function getById(int $id): ?Event
    {
        return Event::find($id);
    }

    public function list(ListEventRequestDTO $input): array
    {
        $query = Event::select('*')
            ->where('company_id', $input->getCompanyId());

        if (!empty($input->getStartDay()) && !empty($input->getEndDay())) {
            $query->whereBetween('date', [$input->getStartDay(), $input->getEndDay()]);
        }

        return $query->get()->toArray();
    }

    public function update(Event $entity): bool
    {
        return $entity->update();
    }

    public function delete(Event $entity): bool
    {
        return $entity->delete();
    }

    public function getByClientId(int $clientId): array
    {
        return Event::where('client_id', $clientId)->get()->toArray();
    }
}
