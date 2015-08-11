<?php

namespace Vinnige\Stub;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Vinnige\Contracts\MiddlewareInterface;

/**
 * Class ValidMiddlewareClass
 * @package Vinnige\Stub
 */
class ValidMiddlewareClass implements MiddlewareInterface
{
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response)
    {
        return $response;
    }
}
