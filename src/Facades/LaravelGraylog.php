<?php

namespace Pigvelop\LaravelGraylog\Facades;

use Illuminate\Support\Facades\Facade;

class LaravelGraylog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravelgraylog';
    }
}
