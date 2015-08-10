<?php

namespace Vinnige\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class BeforeMiddlewareEvent
 * @package Vinning\Events
 */
class BeforeMiddlewareEvent extends Event
{
    /**
     * @var object $request
     */
    protected $request;

    /**
     * @var object $response
     */
    protected $response;

    /**
     * BeforeMiddlewareEvent constructor.
     * @param object $request
     * @param object $response
     */
    public function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * @return object
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param object $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return object
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param object $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }
}
