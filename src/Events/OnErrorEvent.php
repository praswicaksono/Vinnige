<?php

namespace Vinnige\Events;

use Symfony\Component\EventDispatcher\Event;

/**
 * Class OnErrorEvents
 * @package Vinning\Events
 */
class OnErrorEvent extends Event
{
    /**
     * @var \Exception
     */
    protected $exception;

    /**
     * OnErrorEvent constructor.
     * @param \Exception $exception
     */
    public function __construct(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * @return \Exception
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * @param \Exception $exception
     */
    public function setException($exception)
    {
        $this->exception = $exception;
    }
}
