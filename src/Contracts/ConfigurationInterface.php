<?php

namespace Vinnige\Contracts;

/**
 * Interface ConfigurationInterface
 * @package Vinnige\Contracts
 */
interface ConfigurationInterface extends \ArrayAccess
{
    /**
     * @param array $config
     */
    public function merge(array $config);
}
