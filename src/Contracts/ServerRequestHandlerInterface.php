<?php

namespace Vinnige\Contracts;

/**
 * Interface ServerRequestHandlerInterface
 * @package Vinnige\Contracts
 */
interface ServerRequestHandlerInterface
{
    /**
     * @param $request
     * @param $response
     */
    public function handleRequest($request, $response);
}
