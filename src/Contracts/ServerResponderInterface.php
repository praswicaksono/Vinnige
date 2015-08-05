<?php

namespace Vinnige\Contracts;

use Psr\Http\Message\ResponseInterface;

/**
 * Interface ServerResponderInterface
 * @package Vinnige\Contracts
 */
interface ServerResponderInterface
{
    /**
     * @param ResponseInterface $response
     */
    public function send(ResponseInterface $response);
}
