<?php

namespace App\Services\Account;

interface AccountServiceContract
{
    public function getAccountByAccountId(?int $accountId);
    public function getAccountBalanceByAccountId(?int $accountId);
}
