<?php

namespace Vinnige\Stub;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Vinnige\Contracts\ClassBasedRoutingHandlerInterface;

/**
 * Class Controller
 * @package Vinnige\Stub
 */
class Controller implements ClassBasedRoutingHandlerInterface
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $response;
    }
}
