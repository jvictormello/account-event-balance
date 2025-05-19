<?php

namespace App\Services\Event;

use App\Services\Account\AccountServiceContract;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class EventService implements EventServiceContract
{
    const TYPE_DEPOSIT = 'deposit';
    const TYPE_WITHDRAW = 'withdraw';
    const TYPE_TRANSFER = 'transfer';
    protected $accountService;

    public function __construct(AccountServiceContract $accountServiceContract)
    {
        $this->accountService = $accountServiceContract;
    }

    public function executeEvent(array $eventData)
    {
        return match($eventData['type']) {
            self::TYPE_DEPOSIT => $this->accountService->deposit($eventData),
            self::TYPE_WITHDRAW => $this->accountService->withdraw($eventData),
            self::TYPE_TRANSFER => $this->accountService->transfer($eventData),
            default => throw new Exception("Invalid event type.", Response::HTTP_BAD_REQUEST)
        };
    }
}
