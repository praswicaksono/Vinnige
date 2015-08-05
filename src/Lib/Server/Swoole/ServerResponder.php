<?php

namespace Vinnige\Lib\Server\Swoole;

use Psr\Http\Message\ResponseInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerResponderInterface;

/**
 * Class Responder
 * @package Vinnige\Lib\Server
 */
class ServerResponder implements ServerResponderInterface
{
    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @param ContainerInterface $app
     */
    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;
    }

    /**
     * @param ResponseInterface $response
     */
    public function send(ResponseInterface $response)
    {
        /**
         * build response header
         */
        foreach ($response->getHeaders() as $key => $value) {
            $filter_header = function ($header) {
                $filtered = str_replace('-', ' ', $header);
                $filtered = ucwords($filtered);
                return str_replace(' ', '-', $filtered);
            };
            $name = $filter_header($key);
            foreach ($value as $v) {
                $this->app['SwooleResponder']->header($name, $v);
            }
        }

        /**
         * compress content
         */
        if (!empty($this->app['Config']['server.gzip'])) {
            $this->app['SwooleResponder']->gzip($this->app['Config']['server.gzip']);
        }

        $this->app['SwooleResponder']->header('Server', 'vinnige-app-server');

        $this->app['SwooleResponder']->end((string)$response->getBody());
    }
}
