<?php

namespace Vinnige;

use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\EventSubscriberInterface;
use Vinnige\Contracts\MiddlewareInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Vinnige\Events\BeforeRunServer;
use Vinnige\Events\VinnigeEvents;

/**
 * Class Application
 * @package Vinnige
 */
class Application implements ContainerInterface
{
    /**
     * @var array $middlewares
     */
    private $middlewares = [];

    /**
     * @var array $providers
     */
    private $providers = [];

    /**
     * @var array $routes
     */
    private $routes = [];

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Application;
     */
    private static $instance;

    /**
     * @param ConfigurationInterface $config
     * @param ContainerInterface $container
     * @throws \RuntimeException
     */
    public function __construct(ConfigurationInterface $config, ContainerInterface $container)
    {

        $this->container = $container;

        $this['Config'] = $config;
        $this['Container'] = $container;

        $this->bind(ContainerInterface::class, 'Container');
        $this->bind(ConfigurationInterface::class, 'Config');
    }

    /**
     * {@inheritdoc}
     */
    public function singleton($abstract, $concrete = null)
    {
        $this->container->singleton($abstract, $concrete);
    }

    /**
     * {@inheritdoc}
     */
    public function bind($abstract, $concrete = null)
    {
        $this->container->bind($abstract, $concrete);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->container->offsetGet($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->container->offsetSet($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->container->offsetExists($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->container->offsetUnset($offset);
    }

    /**
     * @return $this
     */
    public static function getInstance()
    {
        return static::$instance;
    }

    /**
     * @param Application $application
     */
    public static function setInstance(Application $application)
    {
        static::$instance = $application;
    }

    /**
     * @param ServiceProviderInterface $service
     * @param array $config
     * @return $this
     */
    public function register(ServiceProviderInterface $service, array $config = [])
    {
        $this['Config']->merge($config);

        $this->providers[] = $service;
        $service->register($this);

        if ($service instanceof EventSubscriberInterface) {
            $service->subscribe($this, $this['EventDispatcher']);
        }

        return $this;
    }

    /**
     * @param callable|MiddlewareInterface $middleware
     * @return $this
     * @throws \RuntimeException
     */
    public function middleware($middleware)
    {
        if ($middleware instanceof \Closure) {
            $this->middlewares[] = $middleware;
            return $this;
        }

        if (is_callable($middleware)) {
            if (! $middleware instanceof MiddlewareInterface) {
                throw new \RuntimeException(sprintf('middleware should implement %s', MiddlewareInterface::class));
            }
            $this->container->singleton($middleware);
            $this->middlewares[] = $middleware;
            return $this;
        }

        if (is_string($middleware) && class_exists($middleware)) {
            $this->container->singleton($middleware);
            $this->middlewares[] = $middleware;
            return $this;
        }

        throw new \RuntimeException('invalid middleware');
    }

    /**
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function get($route, callable $handler)
    {
        $this->routes[] = [
            'method' => 'GET',
            'route' => $route,
            'handler' => $handler
        ];

        return $this;
    }

    /**
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function post($route, callable $handler)
    {
        $this->routes[] = [
            'method' => 'POST',
            'route' => $route,
            'handler' => $handler
        ];

        return $this;
    }

    /**
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function put($route, callable $handler)
    {
        $this->routes[] = [
            'method' => 'PUT',
            'route' => $route,
            'handler' => $handler
        ];

        return $this;
    }

    /**
     * @param string $route
     * @param callable $handler
     * @return $this
     */
    public function delete($route, callable $handler)
    {
        $this->routes[] = [
            'method' => 'DELETE',
            'route' => $route,
            'handler' => $handler
        ];

        return $this;
    }

    /**
     * @param string $event
     * @param callable $callback
     * @throws \RuntimeException
     */
    public function serverEvent($event, callable $callback)
    {
        $this->isServerExist();

        $this['Server']->on($event, $callback);
    }

    /**
     * @return array
     */
    public function getMiddlewares()
    {
        return $this->middlewares;
    }

    /**
     * @return array
     */
    public function getServiceProviders()
    {
        return $this->providers;
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * run apps
     */
    public function run()
    {
        /**
         * register application core in container
         */
        $this['Middlewares'] = $this->middlewares;
        $this['ServiceProviders'] = $this->providers;
        $this['Routes'] = $this->routes;

        /**
         * set static instance
         */
        static::setInstance($this);

        /**
         * init routes
         */
        $routeCollector = $this['RouteCollector'];

        foreach ($this['Routes'] as $route) {
            $routeCollector->addRoute($route['method'], $route['route'], $route['handler']);
        }

        $this['EventDispatcher']->dispatch(VinnigeEvents::BEFORE_RUN_SERVER, new BeforeRunServer($this['Server']));
        $this['Server']->run();
    }

    /**
     * @param int $interval
     * @param callable $callback
     * @throws \RuntimeException
     */
    public function once($interval, callable $callback)
    {
        $this->isServerExist();

        $this['Server']->once($interval, $callback);
    }

    /**
     * @param int $interval
     * @param callable $callback
     * @throws \RuntimeException
     */
    public function periodic($interval, callable $callback)
    {
        $this->isServerExist();

        $this['Server']->periodic($interval, $callback);
    }

    /**
     * @return bool
     * @throws \RuntimeException
     */
    public function isServerExist()
    {
        if (! $this->container->offsetExists('Server')) {
            throw new \RuntimeException('server must be set in container');
        }

        return true;
    }
}
