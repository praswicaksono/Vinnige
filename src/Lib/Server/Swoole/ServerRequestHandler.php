<?php

namespace Vinnige\Lib\Server\Swoole;

use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerRequestHandlerInterface;

/**
 * Class RequestHandler
 * @package Vinnige\Lib\Server
 */
class ServerRequestHandler implements ServerRequestHandlerInterface
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
     * @param \swoole_http_request $request
     * @param \swoole_http_response $response
     * @throws \RuntimeException
     */
    public function handleRequest($request, $response)
    {
        try {
            /**
             * put swoole response object to container
             */
            $this->app['SwooleResponder'] = $response;

            $this->setHttpGlobalDefaultValue();

            $request = $this->app['Request'];

            $response = $this->app['Response'];

            /**
             * create middleware dispatcher
             */
            $builder = $this->app['RelayBuilder'];
            $dispatcher = $builder->newInstance($this->app['Middlewares']);

            if (!is_callable($dispatcher)) {
                throw new \RuntimeException('invalid middleware dispatcher');
            }

            /**
             * dispatch middleware
             */
            $response = $dispatcher($request, $response);

            /**
             * send response to client
             */
            $this->app['ServerResponder']->send($response);
        } catch (\Exception $e) {
            $this->app['ErrorHandler']->handleException($e);
        }

    }

    /**
     * set default global
     */
    private function setHttpGlobalDefaultValue()
    {
        if (!array_key_exists('_COOKIE', $GLOBALS)) {
            $_COOKIE = [];
        }

        if (!array_key_exists('_GET', $GLOBALS)) {
            $_GET = [];
        }

        if (!array_key_exists('_POST', $GLOBALS)) {
            $_POST = [];
        }

        if (!array_key_exists('_SESSION', $GLOBALS)) {
            $_SESSION = [];
        }

        if (!array_key_exists('_FILES', $GLOBALS)) {
            $_FILES = [];
        }
    }
}
