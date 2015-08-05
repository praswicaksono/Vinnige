<?php

namespace Vinnige\Contracts;

/**
 * Interface ServiceProviderInterface
 * @package Vinnige\Contracts
 */
interface ServiceProviderInterface
{
    /**
     * @param ContainerInterface $app
     * @return void
     */
    public function register(ContainerInterface $app);
}
