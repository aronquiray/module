<?php

namespace HalcyonLaravel\Module\Providers;

use Illuminate\Support\ServiceProvider;
use  HalcyonLaravel\Module\Commands\CreateModule;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateModule::class,
            ]);
        }
    }
}
