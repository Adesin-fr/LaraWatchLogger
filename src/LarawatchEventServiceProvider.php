<?php

namespace Larawatch;

use Illuminate\Log\Events\MessageLogged;
use Larawatch\Listeners\LarawatchMessageLoggedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;

class LarawatchEventServiceProvider extends EventServiceProvider
{

    protected $listen = [
        MessageLogged::class => [
            LarawatchMessageLoggedListener::class
        ]
    ];


}
