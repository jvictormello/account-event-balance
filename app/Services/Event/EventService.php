<?php

namespace App\Services\Event;

use App\Models\Event;
use App\Repositories\Account\AccountRepositoryContract;
use App\Repositories\Event\EventRepositoryContract;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class EventService implements EventServiceContract
{
    protected $accountRepository;
    protected $eventRepository;

    public function __construct(AccountRepositoryContract $accountRepositoryContract, EventRepositoryContract $eventRepositoryContract)
    {
        $this->accountRepository = $accountRepositoryContract;
        $this->eventRepository = $eventRepositoryContract;
    }

    public function executeEvent(array $eventData)
    {
        switch ($eventData['type']) {
            case Event::EVENT_TYPE_DEPOSIT:
                $account = $this->deposit($eventData);
                $this->eventRepository->store($eventData);

                return ['destination' => ['id' => (string) $account->id, 'balance' => $account->balance]];
                break;
            case Event::EVENT_TYPE_TRANSFER:
                return $this->transfer($eventData);
                break;
            case Event::EVENT_TYPE_WITHDRAW:
                $account = $this->withdraw($eventData);
                $this->eventRepository->store($eventData);

                return ['origin' => ['id' => (string) $account->id, 'balance' => $account->balance]];
                break;
            default:
                throw new Exception("It is not possible perform this action", Response::HTTP_METHOD_NOT_ALLOWED);
        }
    }

    private function deposit(array $eventData)
    {
        $account = $this->accountRepository->getByAttribute('id', $eventData['destination_account_id'])->first();

        if (!$account) {
            $account = $this->accountRepository->store(['id' => $eventData['destination_account_id'], 'balance' => $eventData['amount']]);
        } else {
            $account->balance = $account->balance + $eventData['amount'];
            $account->update();
        }
        return $account;
    }

    private function transfer(array $eventData)
    {
        $originAccount = $this->withdraw($eventData);
        $destinationAccount = $this->deposit($eventData);
        $this->eventRepository->store($eventData);

        return [
            'origin' => [
                'id' => (string) $originAccount->id,
                'balance' => $originAccount->balance
            ],
            'destination' => [
                'id' => (string) $destinationAccount->id,
                'balance' => $destinationAccount->balance
            ]
        ];
    }

    private function withdraw(array $eventData)
    {
        $account = $this->accountRepository->getById($eventData['origin_account_id']);

        if ($account && $account->balance >= $eventData['amount']) {
            $account->balance = $account->balance - $eventData['amount'];
            $account->update();

            return $account;
        } else {
            throw new Exception('A conta de origem não possui saldo suficiente.', Response::HTTP_NOT_FOUND);
        }
    }

    private function saveEvent(array $eventData)
    {
        $this->eventRepository->store($eventData);
    }
}
