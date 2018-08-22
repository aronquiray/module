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

            // Publish module Config
            // $this->publishes([ __DIR__.'/../config/halcyon-laravel/module.php' => config_path('halcyon-laravel/module.php'), ]);
        }
    }
       
    /**
    * Register the application services.
    *
    * @return void
    */
    public function register()
    {
        // Merge module Config
        // $this->mergeConfigFrom(__DIR__.'/../config/halcyon-laravel/module.php', 'halcyon-laravel.module');
    }
}
