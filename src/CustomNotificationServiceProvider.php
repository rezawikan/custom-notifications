<?php

namespace Rezawikan\CustomNotifications;

use Illuminate\Support\ServiceProvider;

class CustomNotificationServiceProvider extends ServiceProvider
{
    protected $commands = [
        'Rezawikan\CustomNotifications\Commands\RestructureNotifications'
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }
}
