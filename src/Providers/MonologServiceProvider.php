<?php

namespace Vinnige\Providers;

use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\HandlerInterface;
use Psr\Log\InvalidArgumentException;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Monolog\Logger;

/**
 * Class MonologServiceProvider
 * @package Vinnige\Providers
 */
class MonologServiceProvider implements ServiceProviderInterface
{
    /**
     * @param ContainerInterface $app
     * @throws \InvalidArgumentException
     */
    public function register(ContainerInterface $app)
    {
        $app->singleton(
            [
                Logger::class => 'Logger'
            ],
            function () use ($app) {
                $logger = new Logger($app['Config']['logger.name']);

                if (!$app['Config']->offsetExists('logger.handler')) {
                    throw new \InvalidArgumentException(
                        'expected at least one logger handler in array(class, array config) format'
                    );
                }

                /**
                 * register logger handler
                 */
                foreach ($app['Config']['logger.handler'] as $class => $config) {
                    $handler = (new \ReflectionClass($class))->newInstance($config['args']);

                    if (!$handler instanceof HandlerInterface) {
                        throw new \InvalidArgumentException(sprintf(
                            'logger handler must implement %s',
                            HandlerInterface::class
                        ));
                    }

                    $formatter = (new \ReflectionClass(key($config['formatter'])))
                        ->newInstance($config['formatter'][key($config['formatter'])]);

                    if (!$formatter instanceof FormatterInterface) {
                        throw new InvalidArgumentException(sprintf(
                            'logger formatter must implement %s',
                            FormatterInterface::class
                        ));
                    }

                    $handler->setFormatter($formatter);

                    $logger->pushHandler($handler);
                }

                return $logger;

            }
        );
    }
}
