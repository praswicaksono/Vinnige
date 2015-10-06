<?php

namespace Vinnige\Lib\Http;

/**
 * Class Query
 * @package Vinnige\Lib\Http
 */
class Query implements \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    private $query;

    /**
     * @param array $query
     */
    public function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * @param string|int $key
     * @return null|mixed
     */
    public function offsetGet($key)
    {
        if ($this->offsetExists($key)) {
            return $this->query[$key];
        }

        return null;
    }

    /**
     * @param string|int $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->query);
    }

    /**
     * @param string|int $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->query[$value] = $key;
    }

    /**
     * @param string|int $key
     */
    public function offsetUnset($key)
    {
        unset($this->query[$key]);
    }

    /**
     * @return int|void
     */
    public function count()
    {
        return count($this->query);
    }
}
