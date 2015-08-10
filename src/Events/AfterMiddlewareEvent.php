<?php

namespace Vinnige\Events;

use Psr\Http\Message\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class AfterMiddlewareEvent
 * @package Vinning\Events
 */
class AfterMiddlewareEvent extends Event
{
    /**
     * @var ResponseInterface $response
     */
    protected $response;

    /**
     * AfterMiddlewareEvent constructor.
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param ResponseInterface $response
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
    }
}
