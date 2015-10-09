<?php

namespace Vinnige\Lib\Http;

/**
 * Class ParsedBody
 * @package Vinnige\Lib\Http
 */
class ParsedBody implements \ArrayAccess, \Countable
{
    /**
     * @var array
     */
    private $post;

    /**
     * @param array $post
     */
    public function __construct(array $post)
    {
        $this->post = $post;
    }

    /**
     * @param string|int $key
     * @return null|mixed
     */
    public function offsetGet($key)
    {
        if ($this->offsetExists($key)) {
            return $this->post[$key];
        }

        return null;
    }

    /**
     * @param string|int $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->post);
    }

    /**
     * @param string|int $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->post[$value] = $key;
    }

    /**
     * @param string|int $key
     */
    public function offsetUnset($key)
    {
        unset($this->post[$key]);
    }

    /**
     * @return int|void
     */
    public function count()
    {
        return count($this->post);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return (array) $this->post;
    }
}
