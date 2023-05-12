<?php

namespace App\Services\Event;

use App\Repositories\Event\EventRepositoryContract;

class EventService implements EventServiceContract
{
    protected $eventRepository;

    public function __construct(EventRepositoryContract $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getAllEvents()
    {
        return $this->eventRepository->all()->toArray();
    }
}
