<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventRequest;
use App\Services\Event\EventServiceContract;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventServiceContract $eventServiceContract)
    {
        $this->eventService = $eventServiceContract;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventRequest $eventRequest): JsonResponse
    {
        $eventData = $eventRequest->validated();

        return response()->json($this->eventService->executeEvent($eventData), Response::HTTP_CREATED);
    }
}
