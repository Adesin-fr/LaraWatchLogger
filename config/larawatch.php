<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Log Levels Watched
    |--------------------------------------------------------------------------
    |
    | An array containing the log levels watched and reported to larawatch.
    | By default this includes emergency, alert, critical, error, and warning.
    |
    */
    'logLevelsWatched' => [
        'emergency',
        'alert',
        'critical',
        'error',
        'warning'
    ],

    'server_url' => env('LARAWATCH_SERVER_URL','https://my.larawatch.pro'),

    'api_key' => env('LARAWATCH_API_KEY', '')

];
