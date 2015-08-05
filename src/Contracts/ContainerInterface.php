<?php

namespace Vinnige\Contracts;

/**
 * Interface ContainerInterface
 * @package Vinnige\Contracts
 */
interface ContainerInterface extends \ArrayAccess
{
    /**
     * @param string|array $abstract
     * @param callable|\Closure|null $concrete
     */
    public function bind($abstract, $concrete = null);

    /**
     * @param string|array $abstract
     * @param callable|\Closure|null $concrete
     */
    public function singleton($abstract, $concrete = null);
}
