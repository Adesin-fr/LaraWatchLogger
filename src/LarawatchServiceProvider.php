<?php

namespace Larawatch;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class LarawatchServiceProvider extends IlluminateServiceProvider
{

    public function boot()
    {
        Log::info("Package booted");

        $configPath = __DIR__ . '/../config/larawatch.php';
        $this->publishes([$configPath => config_path('larawatch.php')], 'config');

    }

    public function register()
    {
        $configPath = __DIR__ . '/../config/larawatch.php';
        $this->mergeConfigFrom($configPath, 'larawatch');

        Log::info("Package registered");
        $this->app->register(LarawatchEventServiceProvider::class);
    }


}
