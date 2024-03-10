<?php

namespace Larawatch\Jobs;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $message;
    private $level;
    private $context;

    public function __construct(string $level, string $message, array $context)
    {
        $this->level = $level;
        $this->message = $message;
        $this->context = $context;
    }

    public function handle()
    {
        if(!in_array($this->level, config('larawatch.logLevelsWatched'))) {
            return false;
        }


        $payload = [
            'level' => $this->level,
            'message' => $this->message,
            'context' => $this->context,
            'userId' => $this->context['userId'] ?? 0,
            'file' => isset($this->context['exception']) ? $this->context['exception']->getFile() : null,
            'line' => isset($this->context['exception']) ? $this->context['exception']->getLine() : null,
            'trace' => isset($this->context['exception']) ? $this->context['exception']->getTraceAsString() : null
        ];

        if(defined('PHPUNIT_TESTS_RUNNING') && PHPUNIT_TESTS_RUNNING) {
            return $payload;
        }

        $client = new Client([
            'base_uri' => config('larawatch.server_url'),
            'defaults' => [
                'exceptions' => false
            ]
        ]);

        try {
            $client->request('POST', '/api/events/create', [
                'json' => $payload,
                'headers' => [
                    'Authorization' => config('larawatch.api_key')
                ]
            ]);
        } catch(Exception $e) {
            dd($e);
        }

        dd("LOG DONE");

        return true;
    }
}
