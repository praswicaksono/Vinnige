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
     * @param int $interval
     * @param callable $callback
     */
    public function once($interval, callable $callback);

    /**
     * @param int $interval
     * @param callable $callback
     */
    public function periodic($interval, callable $callback);

    /**
     * @return void
     */
    public function run();
}
