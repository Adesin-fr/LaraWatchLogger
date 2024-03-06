<?php

namespace Larawatch\Logger;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Http\Request;
use Larawatch\Logger\LarawatchEventServiceProvider;

class LarawatchServiceProvider extends ServiceProvider
{

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/config/larawatch.php' => config_path('larawatch.php'),
        ]);
    }

    public function register()
    {
        $this->app->register(LarawatchEventServiceProvider::class);
    }

    public function provides()
    {

    }

}
