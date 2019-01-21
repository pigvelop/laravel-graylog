<?php

use Monolog\Handler\GelfHandler;
use Monolog\Formatter\GelfMessageFormatter;
use Pigvelop\LaravelGraylog\Facades\LaravelGraylog;

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
                'publisher' => LaravelGraylog::getGelfPublisher(),
            ],
            'formatter' => GelfMessageFormatter::class
        ],
    ],

];
