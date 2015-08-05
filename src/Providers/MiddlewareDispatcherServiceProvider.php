<?php

namespace Vinnige\Providers;

use Vinnige\Application;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\MiddlewareInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Relay\RelayBuilder;

/**
 * Class MiddlewareDispatcherServiceProvider
 * @package Vinnige\Providers
 */
class MiddlewareDispatcherServiceProvider implements ServiceProviderInterface
{
    /**
     * @var ContainerInterface $app
     */
    private $app;

    /**
     * @param ContainerInterface $app
     */
    public function register(ContainerInterface $app)
    {
        $this->app = $app;

        $app->singleton(
            'MiddlewareResolver',
            function () {
                return [$this, 'middlewareResolver'];
            }
        );

        $app->singleton(
            [
                RelayBuilder::class => 'RelayBuilder'
            ],
            function () use ($app) {
                return new RelayBuilder($app['MiddlewareResolver']);
            }
        );
    }

    /**
     * @param $class
     * @return MiddlewareInterface|callable
     * @throws \RuntimeException
     */
    public function middlewareResolver($class)
    {
        if ($class instanceof \Closure) {
            return $class;
        }

        if (is_callable($class)) {
            return $class;
        }

        $concrete = $this->app[$class];

        if (! $concrete instanceof MiddlewareInterface) {
            $message = printf('middleware %s must be instance of %s', $class, MiddlewareInterface::class);

            // TODO: log this error

            throw new \RuntimeException($message);
        }

        return $concrete;
    }
}
