<?php

namespace HalcyonLaravel\Module\Providers;

use HalcyonLaravel\Module\Commands\ModuleCreateCommand;
use HalcyonLaravel\Module\Commands\ModuleDeleteCommand;
use HalcyonLaravel\Module\Commands\ModuleStatusCommand;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    ModuleCreateCommand::class,
                    ModuleStatusCommand::class,
                    ModuleDeleteCommand::class,
                ]
            );
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
