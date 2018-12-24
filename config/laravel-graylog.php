<?php

return [
    'gelf_handler' => env('GELF_HANDLER', false),
    'gelf_host' => env('GELF_HOST', '127.0.0.1'),
    'gelf_port' => env('GELF_PORT', 12202),
];
