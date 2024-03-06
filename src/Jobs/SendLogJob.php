<?php

namespace Larawatch\Logger\Jobs;

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
    private $request;

    public function __construct(MessageLogged $message, Request $request)
    {
        $this->message = $message;
        $this->request = $request;
    }

    public function handle()
    {
        if(!in_array($this->message->level, config('larawatch.logLevelsWatched'))) {
            return false;
        }

        $payload = array(
            'level' => $this->message->level,
            'message' => $this->message->message,
            'route' => $this->request->path(),
            'fullUrl' => $this->request->fullUrl(),
            'ip' => $this->request->ip(),
            'method' => $this->request->method(),
            'userAgent' => $this->request->header('User-Agent'),
            'userId' => isset($this->message->context['userId']) ? $this->message->context['userId'] : 0,
            'file' => isset($this->message->context['exception']) ? $this->message->context['exception']->getFile() : null,
            'line' => isset($this->message->context['exception']) ? $this->message->context['exception']->getLine() : null,
            'trace' => isset($this->message->context['exception']) ? $this->message->context['exception']->getTraceAsString() : null
        );

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
        }

        return true;
    }
}
