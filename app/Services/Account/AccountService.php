<?php

namespace App\Services\Account;

use App\Repositories\Account\AccountRepositoryContract;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class AccountService implements AccountServiceContract
{
    protected $accountRepository;

    public function __construct(AccountRepositoryContract $accountRepositoryContract)
    {
        $this->accountRepository = $accountRepositoryContract;
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
        return $this->getAccountByAccountId($accountId)->balance;
    }
}
