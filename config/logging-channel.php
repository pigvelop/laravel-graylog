<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Graylog Channel
    |--------------------------------------------------------------------------
    |
    | Configuration for graylog channel.
    |
    */

    'graylog' => [
        'driver' => 'monolog',
        'handler' => Monolog\Handler\GelfHandler::class,
        'handler_with' => [
            'publisher' => Pigvelop\LaravelGraylog\Facades\LaravelGraylog::getGelfPublisher(),
        ],
        'formatter' => Monolog\Formatter\GelfMessageFormatter::class
    ],
];
