<?php

use Monolog\Handler\GelfHandler;
use Monolog\Formatter\GelfMessageFormatter;

return [

    /*
    |--------------------------------------------------------------------------
    | Graylog Channel
    |--------------------------------------------------------------------------
    |
    | Configuration for graylog channel.
    |
    */

    'channels' => [
        'graylog' => [
            'driver' => 'monolog',
            'handler' => GelfHandler::class,
            'handler_with' => [
                'publisher' => app()->make('laravelgraylog')->getGelfPublisher(),
            ],
            'formatter' => GelfMessageFormatter::class
        ],
    ],

];
