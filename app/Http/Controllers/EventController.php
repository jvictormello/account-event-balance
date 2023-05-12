<?php

namespace App\Http\Controllers;

use App\Services\Event\EventServiceContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        try {
            $eventData = [];
            $eventData['type'] = $request->has('type') ? $request->get('type') : null;
            $eventData['destination_account_id'] = $request->has('destination') ? $request->get('destination') : null;
            $eventData['origin_account_id'] = $request->has('origin') ? $request->get('origin') : null;
            $eventData['amount'] = $request->has('amount') ? $request->get('amount') : null;

            return response()->json($this->eventService->executeEvent($eventData), Response::HTTP_CREATED);
        } catch (ModelNotFoundException $exception) {
            return response()->json(0, Response::HTTP_NOT_FOUND);
        } catch (Exception $exception) {
            return response()->json(0, Response::HTTP_NOT_FOUND);
        }
    }
}
