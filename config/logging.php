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
                'publisher' => app(Pigvelop\LaravelGraylog\LaravelGraylog::class)->getGelfPublisher(),
            ],
            'formatter' => GelfMessageFormatter::class
        ],
    ],

];