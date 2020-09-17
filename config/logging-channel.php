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
        'name' => env('GELF_NAME', 'local'),
        'handler' => Monolog\Handler\GelfHandler::class,
        'handler_with' => [
            'publisher' => Pigvelop\LaravelGraylog\Facades\LaravelGraylog::getGelfPublisher(),
        ],
        'formatter' => Monolog\Formatter\GelfMessageFormatter::class
    ],
];
