<?php

namespace Pigvelop\LaravelGraylog;

use Gelf\Publisher;
use Gelf\Transport\UdpTransport;
use Monolog\Handler\GelfHandler;

/**
 * LaravelGraylog Class
 */
class LaravelGraylog
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The service configuration
     *
     * @var array
     */
    protected $config;

    /**
     * Create instance for LaravelGraylog
     */
    public function __construct($app, $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * Push Monolog Handler for Gelf.
     *'
     * @return void
     */
    public function pushHandler()
    {
        if ($this->config['gelf_handler'] === 'configure') {
            $this->app->configureMonologUsing(function ($monolog) {
                $monolog->pushHandler($this->createGelfHandler());

                return $monolog;
            });
        } elseif ($this->config['gelf_handler'] || $this->config['gelf_handler'] === 'push') {
            $this->app['log']->pushHandler($this->createGelfHandler());
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
                $this->config['gelf_host'],
                $this->config['gelf_port'],
                UdpTransport::CHUNK_SIZE_LAN
            )
        );
        
        return new GelfHandler($publisher);
    }
}
