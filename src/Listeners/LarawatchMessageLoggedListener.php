<?php

namespace Larawatch\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Log;
use Larawatch\Jobs\SendLogJob;

class LarawatchMessageLoggedListener
{
    public function __construct()
    {
    }

    public function handle(MessageLogged $logEntry)
    {
        Log::info("Handle messageLog context : ");
        Log::info($logEntry->context);
        SendLogJob::dispatch([
            $logEntry->level,
            $logEntry->message,
//            $logEntry->context
        ]);
    }

}
