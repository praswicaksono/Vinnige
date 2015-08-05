<?php

namespace Vinnige\Lib\Config;

use Vinnige\Contracts\ConfigurationInterface;

/**
 * Class Config
 * @package Vinnige\Lib\Config
 */
class Config implements ConfigurationInterface
{
    private $config = [];

    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * @param string $key
     */
    public function offsetUnset($key)
    {
        unset($this->config[$key]);
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->config[$key];
    }

    /**
     * @param string $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->config);
    }

    /**
     * @param array $config
     */
    public function merge(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }
}
