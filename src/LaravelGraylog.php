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
     * The service configuration
     *
     * @var array
     */
    protected $config;

    /**
     * Create instance for LaravelGraylog
     */
    public function __construct($config)
    {
        $this->config = $config;
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
}
