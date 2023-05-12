<?php

namespace App\Services\Event;

use App\Repositories\Event\EventRepositoryContract;

class EventService implements EventServiceContract
{
    protected $eventRepository;

    public function __construct(EventRepositoryContract $eventRepositoryContract)
    {
        $this->eventRepository = $eventRepositoryContract;
    }

    public function getAllEvents()
    {
        return $this->eventRepository->all()->toArray();
    }
}
