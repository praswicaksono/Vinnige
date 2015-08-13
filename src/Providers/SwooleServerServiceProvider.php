<?php

namespace Vinnige\Providers;

use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerInterface;
use Vinnige\Contracts\ServerRequestHandlerInterface;
use Vinnige\Contracts\ServerResponderInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Vinnige\Lib\Server\Swoole\Server;
use Vinnige\Lib\Server\Swoole\ServerRequestHandler;
use Vinnige\Lib\Server\Swoole\ServerResponder;

/**
 * Class SwooleServerServiceProvider
 * @package Vinnige\Providers
 */
class SwooleServerServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $app
     */
    public function register(ContainerInterface $app)
    {
        /**
         * swoole server
         */
        $app->singleton(
            'Server',
            function () use ($app) {
                return new Server($app);
            }
        );

        /**
         * swoole server request handler
         */
        $app->singleton(
            'ServerRequestHandler',
            function () use ($app) {
                return new ServerRequestHandler($app, $app['EventDispatcher']);
            }
        );

        /**
         * swoole server responder
         */
        $app->singleton(
            'ServerResponder',
            function () use ($app) {
                return new ServerResponder($app);
            }
        );

        $app->bind(ServerInterface::class, 'Server');
        $app->bind(ServerRequestHandlerInterface::class, 'ServerRequestHandler');
        $app->bind(ServerResponderInterface::class, 'ServerResponder');
    }
}
