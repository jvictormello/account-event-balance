<?php

namespace App\Providers;

use App\Services\Account\AccountServiceContract;
use App\Services\Account\AccountService;
use Illuminate\Support\ServiceProvider;

class AccountServiceServiceProvider extends ServiceProvider
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
            AccountServiceContract::class,
            AccountService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [AccountServiceContract::class];
    }
}
