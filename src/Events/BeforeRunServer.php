<?php

namespace Vinnige\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BeforeRunServer
 * @package Vinning\Events
 */
class BeforeRunServer extends Event
{
    /**
     * @var object $server
     */
    protected $server;

    /**
     * BeforeRunServer constructor.
     * @param object $server
     */
    public function __construct($server)
    {
        $this->server = $server;
    }

    /**
     * @return object
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param object $server
     */
    public function setServer($server)
    {
        $this->server = $server;
    }
}
