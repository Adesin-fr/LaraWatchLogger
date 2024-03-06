<?php

declare(strict_types=1);

namespace Larawatch;
use Monolog\Logger as MonologLogger;

class Logger
{
    public function __invoke(array $config)
    {
        $logger = new MonologLogger('larawatch');
        $logger->pushHandler(new LarawatchHandler());
        $logger->pushProcessor(new RequestProcessor());

        return $logger;
    }
}
