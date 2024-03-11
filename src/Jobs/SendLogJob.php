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
use InvalidArgumentException;

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
        if (!in_array($this->level, config('larawatch.logLevelsWatched'))) {
            return false;
        }


        $payload = [
            'level' => $this->level,
            'message' => $this->message,
            'userId' => $this->context['userId'] ?? 0,
            'file' => isset($this->context['exception']) ? $this->context['exception']->getFile() : null,
            'line' => isset($this->context['exception']) ? $this->context['exception']->getLine() : null,
            'trace' => isset($this->context['exception']) ? $this->context['exception']->getTraceAsString() : null,
        ];

        if ($payload['file'] && $payload['line']) {
            $payload['codeExcerpt'] = $this->getCodeExcerpt($payload['file'], $payload['line']);
        }

        if (defined('PHPUNIT_TESTS_RUNNING') && PHPUNIT_TESTS_RUNNING) {
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
        } catch (Exception $e) {
        }

        return true;
    }

    private function getCodeExcerpt(string $file, $line)
    {
        if (null !== ($contents = file_get_contents($file))) {
            $lines = explode("\n", $contents);

            $start = (int)$line - 2;

            if ($start < 0) {
                $start = 0;
            }

            return array_slice($lines, $start,  10, true);
        }

        return [];
    }


}
