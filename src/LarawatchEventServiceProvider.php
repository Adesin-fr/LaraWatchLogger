<?php

namespace Larawatch\Logger;

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Support\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Http\Request;
use Larawatch\Logger\Listeners\LarawatchListener;

class LarawatchEventServiceProvider extends EventServiceProvider
{

    protected $listen = [
        MessageLogged::class => [
            LarawatchListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }

}
