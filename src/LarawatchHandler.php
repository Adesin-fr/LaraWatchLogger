<?php

namespace Larawatch\Logger;

use Larawatch\Logger\Jobs\SendLogJob;
use Monolog\Logger;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;

class LarawatchHandler extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        SendLogJob::dispatch($record, request());
    }

    /**
     * {@inheritDoc}
     */
    protected function getDefaultFormatter(): FormatterInterface
    {
        return new LarawatchFormatter();
    }
}
