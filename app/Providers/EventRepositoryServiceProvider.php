<?php

namespace App\Providers;

use App\Repositories\Event\EventRepositoryEloquentContract;
use App\Repositories\Event\EventRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class EventRepositoryServiceProvider extends ServiceProvider
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
            EventRepositoryEloquentContract::class,
            EventRepositoryEloquent::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [EventRepositoryEloquentContract::class];
    }
}
