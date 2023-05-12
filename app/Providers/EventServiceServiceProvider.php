<?php

namespace App\Providers;

use App\Services\Event\EventServiceContract;
use App\Services\Event\EventService;
use Illuminate\Support\ServiceProvider;

class EventServiceServiceProvider extends ServiceProvider
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
            EventServiceContract::class,
            EventService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        return [EventServiceContract::class];
    }
}
