<?php

namespace App\Services\Account;

interface AccountServiceContract
{
    public function getAccountByAccountId(?int $accountId);
    public function getAccountBalanceByAccountId(?int $accountId);
    public function deposit(array $eventData);
    public function withdraw(array $eventData);
    public function transfer(array $eventData);
}
