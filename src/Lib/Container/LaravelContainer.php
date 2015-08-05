<?php

namespace Vinnige\Lib\Container;

use Illuminate\Contracts\Container\Container;
use Vinnige\Contracts\ContainerInterface;

/**
 * Class LaravelContainer
 * @package Vinnige\Lib\Container
 */
class LaravelContainer implements ContainerInterface
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param array|string $abstract
     * @param callable|\Closure|null $concrete
     */
    public function bind($abstract, $concrete = null)
    {
        $this->container->bind($abstract, $concrete);
    }

    /**
     * @param array|string $abstract
     * @param null $concrete
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->container->singleton($abstract, $concrete);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->container[$key];
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->container[$key] = $value;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->container->offsetExists($key);
    }

    /**
     * @param string $key
     */
    public function offsetUnset($key)
    {
        $this->container->offsetUnset($key);
    }
}
