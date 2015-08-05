<?php

namespace Vinnige\Contracts;

/**
 * Interface ServerContractInterface
 * @package Vinnige\Contracts
 */
interface ServerInterface
{
    /**
     * @param string $event
     * @param callable $callback
     * @return void
     */
    public function on($event, callable $callback);

    /**
     * @return void
     */
    public function run();
}
