<?php

namespace Larawatch\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Larawatch\Jobs\SendLogJob;

class LarawatchMessageLoggedListener
{
    public function __construct()
    {
    }

    public function handle(MessageLogged $logEntry)
    {
        SendLogJob::dispatch([
            $logEntry->level,
            $logEntry->message,
            $logEntry->context
        ]);
    }

}
