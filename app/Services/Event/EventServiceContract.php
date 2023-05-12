<?php

namespace App\Services\Event;

interface EventServiceContract
{
    public function executeEvent(array $eventData);
}
