<?php

namespace Vinnige\Middlewares;

use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased as RouteDispatcher;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vinnige\Contracts\ClassBasedRoutingHandlerInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\MiddlewareInterface;
use Vinnige\Lib\Http\Exceptions\InternalErrorHttpException;
use Vinnige\Lib\Http\Exceptions\MethodNotAllowedHttpException;
use Vinnige\Lib\Http\Exceptions\NotFoundHttpException;
use Vinnige\Events\BeforeDispatchRouteEvent;
use Vinnige\Events\BeforeRouteEvent;
use Vinnige\Events\VinnigeEvents;

/**
 * Class RoutingMiddleware
 * @package Vinnige\Middlewares
 */
class RoutingMiddleware implements MiddlewareInterface
{
    /**
     * @var RouteDispatcher
     */
    private $dispatcher;

    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @var EventDispatcherInterface
     */
    private $event;

    /**
     * @param RouteDispatcher $dispatcher
     * @param ContainerInterface $app
     * @param EventDispatcherInterface $event
     */
    public function __construct(RouteDispatcher $dispatcher, ContainerInterface $app, EventDispatcherInterface $event)
    {
        $this->dispatcher = $dispatcher;
        $this->app = $app;
        $this->event = $event;
    }

    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param callable $next
     * @return ResponseInterface
     * @throws NotFoundHttpException
     * @throws MethodNotAllowedHttpException
     * @throws InternalErrorHttpException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next)
    {
        /**
         * dispatch before route
         */
        $this->event->dispatch(VinnigeEvents::BEFORE_ROUTE, new BeforeRouteEvent($request));

        $info = $this->dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($info[0]) {
            case Dispatcher::NOT_FOUND:
                throw new NotFoundHttpException('not found');
                break;
            case Dispatcher::METHOD_NOT_ALLOWED:
                throw new MethodNotAllowedHttpException([$info[0][1]], 'method not allowed');
                break;
            case Dispatcher::FOUND:
                $request = $request->withAttribute('param', $info[2]);

                /**
                 * dispatch before dispatch event
                 */
                $this->event->dispatch(
                    VinnigeEvents::BEFORE_DISPATCH_ROUTE,
                    new BeforeDispatchRouteEvent($request, $info[1])
                );

                if (is_callable($info[1])) {
                    $response = $info[1]($request, $response);
                } else {
                    $controller = $this->app[$info[1]];

                    if (! $controller instanceof ClassBasedRoutingHandlerInterface) {
                        throw new InternalErrorHttpException(
                            sprintf('class %s must implement %s', $info[1], ClassBasedRoutingHandlerInterface::class)
                        );
                    }

                    /**
                     * resolve middleware from container and invoke it
                     */
                    $response = $controller($request, $response);
                }

                return $next($request, $response, $next);

                break;
            default:
                throw new InternalErrorHttpException('routing error');
        }
    }
}
