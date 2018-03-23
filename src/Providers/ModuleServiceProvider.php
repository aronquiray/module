<?php

namespace HalcyonLaravel\Module\Providers;

use Illuminate\Support\ServiceProvider;
use  HalcyonLaravel\Module\Commands\ModuleCreateCommand;
use  HalcyonLaravel\Module\Commands\ModuleStatusCommand;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleCreateCommand::class,
                ModuleStatusCommand::class,
            ]);
        }
    }
}
