<?php

namespace HalcyonLaravel\Module\Providers;

use Illuminate\Support\ServiceProvider;
use  HalcyonLaravel\Module\Commands\ModuleCreateCommand;
use  HalcyonLaravel\Module\Commands\ModuleStatusCommand;
use  HalcyonLaravel\Module\Commands\ModuleDeleteCommand;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModuleCreateCommand::class,
                ModuleStatusCommand::class,
                ModuleDeleteCommand::class,
            ]);
        }
    }
}
