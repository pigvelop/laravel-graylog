<?php

namespace Pigvelop\LaravelGraylog;

use Illuminate\Support\Facades\Config;
use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;
use Illuminate\Support\Facades\Log;

/**
 * LaravelGraylog Class
 */
class LaravelGraylog
{
    /**
     * Enable/Disable GELF Hanlder
     *
     * @var boolean
     */
    protected $gelfHandler;

    /**
     * GELF Server hostname.
     *
     * @var string
     */
    protected $gelfHost;

    /**
     * GELF Server port number.
     *
     * @var int
     */
    protected $gelfPort;

    /**
     * Create instance for LaravelGraylog
     */
    public function __construct()
    {
        $this->gelfHandler = Config::get('laravel-graylog.gelf_handler');
        $this->gelfHost = Config::get('laravel-graylog.gelf_host');
        $this->gelfPort = Config::get('laravel-graylog.gelf_port');
    }

    /**
     * Push Monolog Handler for Gelf.
     *
     * @return void
     */
    public function pushHandler()
    {
        if ($this->gelfHandler === 'configure') {
            app()->configureMonologUsing(function ($monolog) {
                $monolog->pushHandler($this->createGelfHandler());
            });
        } elseif ($this->gelfHandler || $this->gelfHandler === 'push') {
            Log::getMonolog()->pushHandler($this->createGelfHandler());
        }
    }

    /**
     * Create a Gelf Handler instance.
     *
     * @return Monolog\Handler\GelfHandler
     */
    protected function createGelfHandler() : object
    {
        $publisher = new Publisher();
        
        $publisher->addTransport(
            new UdpTransport(
                $this->gelfHost,
                $this->gelfPort,
                UdpTransport::CHUNK_SIZE_LAN
            )
        );
        
        return new GelfHandler($publisher);
    }
}
