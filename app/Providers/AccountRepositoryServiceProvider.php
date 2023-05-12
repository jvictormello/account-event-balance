<?php

namespace App\Providers;

use App\Repositories\Account\AccountRepositoryContract;
use App\Repositories\Account\AccountRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AccountRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            AccountRepositoryContract::class,
            AccountRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [AccountRepositoryContract::class];
    }
}
