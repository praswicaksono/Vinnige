<?php

namespace spec\Vinnige\Middlewares;

use FastRoute\Dispatcher;
use FastRoute\Dispatcher\GroupCountBased;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Lib\Http\Exceptions\NotFoundHttpException;
use Vinnige\Lib\Http\Exceptions\MethodNotAllowedHttpException;
use Vinnige\Lib\Http\Exceptions\InternalErrorHttpException;
use Vinnige\Stub\Controller;

class RoutingMiddlewareSpec extends ObjectBehavior
{
    public function let(GroupCountBased $dispatcher, ContainerInterface $container, EventDispatcherInterface $event)
    {
        $this->beConstructedWith($dispatcher, $container, $event);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Middlewares\RoutingMiddleware');
    }

    public function it_should_throw_exception_when_route_is_not_match(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            Dispatcher::NOT_FOUND
        ]);

        $this->shouldThrow(NotFoundHttpException::class)->during('__invoke', [
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        ]);
    }

    public function it_should_throw_exception_when_method_is_invalid(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            Dispatcher::METHOD_NOT_ALLOWED
        ]);

        $this->shouldThrow(MethodNotAllowedHttpException::class)->during('__invoke', [
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        ]);
    }

    public function it_should_able_handle_callable_when_route_is_match(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            Dispatcher::FOUND,
            function ($request, $response) {
                return $response;
            },
            []
        ]);

        $request->withAttribute('param', [])->shouldBeCalled();

        $this->__invoke(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        )->shouldReturn($response);
    }

    public function it_should_throw_exception_when_class_is_not_implement_interface(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher,
        ContainerInterface $container
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            Dispatcher::FOUND,
            'Test',
            []
        ]);

        $request->withAttribute('param', [])->shouldBeCalled();

        $container->offsetGet('Test')->willReturn(new \ArrayObject());

        $this->shouldThrow(InternalErrorHttpException::class)->during('__invoke', [
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        ]);
    }

    public function it_should_handle_class_when_route_is_match(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher,
        ContainerInterface $container
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            Dispatcher::FOUND,
            'Controller',
            []
        ]);

        $request->withAttribute('param', [])->willReturn($request);

        $container->offsetGet('Controller')->willReturn(new Controller());

        $this->__invoke(
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        )->shouldReturn($response);
    }

    public function it_should_throw_exception_when_unknown_routing_status(
        ServerRequestInterface $request,
        UriInterface $uri,
        ResponseInterface $response,
        GroupCountBased $dispatcher
    ) {
        $request->getMethod()->willReturn('GET');
        $request->getUri()->willReturn($uri);
        $uri->getPath()->willReturn('/');

        $dispatcher->dispatch('GET', '/')->willReturn([
            99999
        ]);

        $this->shouldThrow(InternalErrorHttpException::class)->during('__invoke', [
            $request,
            $response,
            function ($request, $response) {
                return $response;
            }
        ]);
    }
}
