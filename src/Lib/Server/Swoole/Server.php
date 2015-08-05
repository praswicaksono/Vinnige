<?php

namespace Vinnige\Lib\Server\Swoole;

use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerInterface;

/**
 * Class Server
 * @package Vinnige\Lib\Server\Swoole
 */
class Server implements ServerInterface
{
    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @var \swoole_http_server
     */
    private $server;

    /**
     * @param ContainerInterface $app
     */
    public function __construct(ContainerInterface $app)
    {
        $this->app = $app;

        /**
         * create new swoole object
         */
        $this->server = new \swoole_http_server(
            $this->app['Config']['server.hostname'],
            $this->app['Config']['server.port'],
            SWOOLE_PROCESS
        );

        /**
         * set swoole configuration
         */
        $this->server->setGlobal(HTTP_GLOBAL_ALL);
        $this->server->set($this->app['Config']['server.config']);
    }

    /**
     * @param string $event
     * @param callable $callback
     */
    public function on($event, callable $callback)
    {
        /**
         * register request handler
         */
        $this->server->on(
            $event,
            $callback
        );
    }

    /**
     * run server
     */
    public function run()
    {

        $this->app['Swoole'] = $this->server;

        echo "server started on http://{$this->app['Config']['server.hostname']}:{$this->app['Config']['server.port']}"
            . PHP_EOL;
        echo swoole_version() . PHP_EOL;

        /**
         * start swoole http server
         */
        $this->server->start();
    }
}
