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
                $monolog->pushHandler(new GelfHandler($this->getGelfPublisher()));

                return $monolog;
            });
        } elseif ($this->config['gelf_handler'] || $this->config['gelf_handler'] === 'push') {
            if ($this->isLumen()) {
                $monolog = $this->app['Psr\Log\LoggerInterface'];
            } else {
                $monolog = $this->app['log']->getMonolog();
            }

            $monolog->pushHandler(new GelfHandler($this->getGelfPublisher()));
        }
    }

    /**
     * Create a Gelf Publisher.
     *
     * @return Publisher
     */
    public function getGelfPublisher() : Publisher
    {
        $publisher = new Publisher();
        
        $publisher->addTransport(
            new UdpTransport(
                $this->config['gelf_host'],
                $this->config['gelf_port'],
                UdpTransport::CHUNK_SIZE_LAN
            )
        );

        return $publisher;
    }

    /**
     * Check if app uses Lumen.
     *
     * @return bool
     */
    protected function isLumen() : bool
    {
        return str_contains($this->app->version(), 'Lumen');
    }
}
