<?php

namespace Vinnige\Providers;

use PHPixie\Slice;
use Psr\Http\Message\StreamInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\EventSubscriberInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use PHPixie\HTTP;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * Class KernelServiceProvider
 * @package Vinnige\Providers
 */
class KernelServiceProvider implements ServiceProviderInterface, EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @param ContainerInterface $app
     * @throws \RuntimeException
     */
    public function register(ContainerInterface $app)
    {
        $this->app = $app;

        /**
         * register http message
         */
        $this->registerHttpMessageProvider();

        /**
         * register event dispatcher
         */
        $this->registerEventDispatcherProvider();


    }

    /**
     * @param ContainerInterface $app
     * @param EventDispatcherInterface $dispatcher
     */
    public function subscribe(ContainerInterface $app, EventDispatcherInterface $dispatcher)
    {

    }

    private function registerHttpMessageProvider()
    {
        /**
         * PSR-7 messages
         */
        $this->app->singleton(
            'Http',
            function () {
                return (new HTTP(new Slice()))->messages();
            }
        );

        /**
         * register PSR-7 server request
         */
        $this->app->bind(
            [
                HTTP::class => 'Request'
            ],
            function () {
                return $this->app['Http']->sapiServerRequest();
            }
        );

        /**
         * register PSR-7 http body stream
         */
        foreach ($this->app['Config']['http.streams'] as $class => $args) {
            $this->app->bind(
                $class,
                function () use ($class, $args) {
                    $stream = (new \ReflectionClass($class))->newInstance($args);
                    if (! $stream instanceof StreamInterface) {
                        throw new \RuntimeException(
                            sprintf('Http response stream must be instance of %s', StreamInterface::class)
                        );
                    }

                    return $stream;
                }
            );
        }

        /**
         * register PSR-7 response
         */
        $this->app->bind(
            [
                $this->app['Config']['http.response']['class'] => 'Response'
            ],
            function () {
                return $this->app['Http']->response(
                    $this->app['Config']['http.response']['protocol.version'],
                    $this->app['Config']['http.response']['header'],
                    $this->app[$this->app['Config']['http.response']['stream']]
                );
            }
        );

        /**
         * binding PSR-7 interface to our implementation
         */
        $this->app->bind(ServerRequestInterface::class, 'Request');
        $this->app->bind(ResponseInterface::class, 'Response');
    }

    private function registerEventDispatcherProvider()
    {
        $this->app->singleton(
            [
                EventDispatcher::class => 'EventDispatcher'
            ],
            function () {
                return new EventDispatcher();
            }
        );

        $this->app->bind(EventDispatcherInterface::class, 'EventDispatcher');
    }
}
