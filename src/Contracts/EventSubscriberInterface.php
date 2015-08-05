<?php

namespace Vinnige\Contracts;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Interface EventSubscriberInterface
 * @package Vinnige\Contracts
 */
interface EventSubscriberInterface
{
    /**
     * @param ContainerInterface $application
     * @param EventDispatcherInterface $dispatcher
     */
    public function subscribe(ContainerInterface $application, EventDispatcherInterface $dispatcher);
}
