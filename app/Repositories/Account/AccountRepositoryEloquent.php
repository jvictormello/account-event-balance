<?php

namespace App\Repositories\Account;

use App\Models\Account;
use App\Repositories\BaseRepositoryEloquent;

class AccountRepositoryEloquent extends BaseRepositoryEloquent implements AccountRepositoryContract
{
    protected $model;

    public function __construct(Account $account)
    {
        $this->model = $account;
    }
}
