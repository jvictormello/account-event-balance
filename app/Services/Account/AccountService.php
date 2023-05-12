<?php

namespace App\Services\Account;

use App\Repositories\Account\AccountRepositoryContract;

class AccountService implements AccountServiceContract
{
    protected $accountRepository;

    public function __construct(AccountRepositoryContract $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function getAllAccounts()
    {
        return $this->accountRepository->all()->toArray();
    }
}
