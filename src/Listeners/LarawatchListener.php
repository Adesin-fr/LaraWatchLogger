<?php

namespace Larawatch\Logger\Listeners;

use Illuminate\Log\Events\MessageLogged;
use Larawatch\Logger\Jobs\SendLogJob;

class LarawatchListener
{

    public function __construct()
    {

    }

    public function handle(MessageLogged $message)
    {
        SendLogJob::dispatch($message, app()->request);
    }

}
