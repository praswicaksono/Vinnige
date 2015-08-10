<?php

namespace Vinnige\Events;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class BeforeDispatchRouteEvent
 * @package Vinning\Events
 */
class BeforeDispatchRouteEvent extends Event
{
    /**
     * @var ServerRequestInterface $request
     */
    protected $request;

    /**
     * @var callable|string
     */
    protected $handler;

    /**
     * BeforeDispatcherEvent constructor.
     * @param ServerRequestInterface $request
     * @param callable|string $handler
     */
    public function __construct($request, $handler)
    {
        $this->request = $request;
        $this->handler = $handler;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return callable|string
     */
    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * @param callable|string $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
    }
}
