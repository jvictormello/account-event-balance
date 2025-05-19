<?php

namespace App\Services\Account;

use App\Repositories\Account\AccountRepositoryEloquentContract;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpFoundation\Response;

class AccountService implements AccountServiceContract
{
    protected $accountRepository;

    public function __construct(AccountRepositoryEloquentContract $accountRepositoryEloquentContract)
    {
        $this->accountRepository = $accountRepositoryEloquentContract;
    }

    public function getAccountByAccountId(?int $accountId)
    {
        if (!$accountId) {
            throw new Exception('account_id must be valid', Response::HTTP_NOT_FOUND);
        }
        return $this->accountRepository->getById($accountId);
    }

    public function getAccountBalanceByAccountId(?int $accountId)
    {
        $account = self::getAccountByAccountId($accountId);

        if (!$account) {
            throw new ModelNotFoundException();
        }

        return $account->balance;
    }

    public function deposit(array $eventData)
    {
        if ($eventData['amount'] <= 0) {
            throw new Exception('Invalid amount.');
        }

        $account = $this->accountRepository->getById($eventData['destination']);

        if (!$account) {
            $account = $this->accountRepository->store([
                'id' => $eventData['destination'],
                'balance' => $eventData['amount']
            ]);
        } else {
            $account->balance += $eventData['amount'];
            $account->save();
        }

        return [
            'destination' => [
                'id' => (string) $account->id,
                'balance' => $account->balance
            ]
        ];
    }

    public function withdraw(array $eventData)
    {
        if ($eventData['amount'] <= 0) {
            throw new Exception('Invalid amount.');
        }

        $account = $this->accountRepository->getById($eventData['origin']);

        if (!$account) {
            throw new ModelNotFoundException();
        }

        if ($account->balance < $eventData['amount']) {
            throw new Exception('Insufficient balance.');
        }

        $account->balance -= $eventData['amount'];
        $account->save();

        return [
            'origin' => [
                'id' => (string) $account->id,
                'balance' => $account->balance
            ]
        ];
    }

    public function transfer(array $eventData)
    {
        if ($eventData['origin'] === $eventData['destination']) {
            throw new Exception('Invalid transfer. Origin and destination cannot be the same.', 400);
        }

        if ($eventData['amount'] <= 0) {
            throw new Exception('Invalid amount.');
        }

        // Reutiliza os métodos withdraw e deposit
        $origin = $this->withdraw([
            'origin' => $eventData['origin'],
            'amount' => $eventData['amount']
        ]);

        $destination = $this->deposit([
            'destination' => $eventData['destination'],
            'amount' => $eventData['amount']
        ]);

        return [
            'origin' => $origin['origin'],
            'destination' => $destination['destination']
        ];
    }
}
