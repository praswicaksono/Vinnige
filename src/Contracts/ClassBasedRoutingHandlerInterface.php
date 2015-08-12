<?php

namespace Vinnige\Contracts;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface ClassBasedRoutingHandlerInterface
 * @package Vinnige\Contracts
 */
interface ClassBasedRoutingHandlerInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response);
}
