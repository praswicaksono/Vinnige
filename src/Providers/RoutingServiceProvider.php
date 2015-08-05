<?php

namespace Vinnige\Providers;

use FastRoute\RouteParser\Std as RouteParser;
use FastRoute\RouteParser as RouteParserInterface;
use FastRoute\DataGenerator\GroupCountBased as DataGenerator;
use FastRoute\DataGenerator as DataGeneratorInterface;
use FastRoute\RouteCollector;
use FastRoute\Dispatcher\GroupCountBased as RouteDispatcher;
use Vinnige\Application;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServiceProviderInterface;

/**
 * Class RoutingServiceProvider
 * @package Vinnige\Providers
 */
class RoutingServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $app
     */
    public function register(ContainerInterface $app)
    {
        $app->singleton(
            [
                RouteParser::class => 'RouteParser'
            ]
        );

        $app->singleton(
            [
                DataGenerator::class => 'DataGenerator'
            ]
        );

        $app->singleton(
            [
                RouteCollector::class => 'RouteCollector'
            ]
        );

        /**
         * contextual binding
         */
        $app->bind(RouteParserInterface::class, 'RouteParser');
        $app->bind(DataGeneratorInterface::class, 'DataGenerator');

        /**
         * register routing dispatcher
         */
        $app->singleton(
            [
                RouteDispatcher::class => 'RouteDispatcher'
            ],
            function () use ($app) {
                return new RouteDispatcher($app['RouteCollector']->getData());
            }
        );

    }
}
