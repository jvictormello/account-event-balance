<?php

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\BaseRepositoryEloquent;

class EventRepositoryEloquent extends BaseRepositoryEloquent implements EventRepositoryContract
{
    protected $model;

    public function __construct(Event $event)
    {
        $this->model = $event;
    }
}
