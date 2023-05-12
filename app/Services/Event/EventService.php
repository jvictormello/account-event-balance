<?php

namespace App\Services\Event;

use App\Repositories\Event\EventRepositoryContract;

class EventService implements EventServiceContract
{
    protected $eventRepository;

    public function __construct(EventRepositoryContract $eventRepository)
    {
        $this->EventRepository = $eventRepository;
    }

    public function getAllEvents()
    {
        return $this->EventRepository->all()->toArray();
    }
}
