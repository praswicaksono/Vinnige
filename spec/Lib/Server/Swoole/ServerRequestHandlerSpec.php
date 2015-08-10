<?php

namespace spec\Vinnige\Lib\Server\Swoole;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Relay\RelayBuilder;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerResponderInterface;

class ServerRequestHandlerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container, EventDispatcherInterface $event)
    {
        $this->beConstructedWith($container, $event);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Server\Swoole\ServerRequestHandler');
    }

    public function it_should_able_handle_incoming_request(
        \swoole_http_request $swoole_req,
        \swoole_http_response $swoole_res,
        ServerRequestInterface $request,
        ResponseInterface $response,
        RelayBuilder $relayBuilder,
        ContainerInterface $container,
        ServerResponderInterface $serverResponder,
        EventDispatcherInterface $event
    ) {
        unset($GLOBALS['_COOKIE']);
        unset($GLOBALS['_GET']);
        unset($GLOBALS['_POST']);
        unset($GLOBALS['_FILES']);

        $container->offsetSet('SwooleResponder', $swoole_res)->shouldBeCalled();

        $container->offsetGet('Request')->willReturn($request);
        $container->offsetGet('Response')->willReturn($response);

        $container->offsetGet('RelayBuilder')->willReturn($relayBuilder);

        $container->offsetGet('Middlewares')->willReturn([]);

        $container->offsetGet('EventDispatcher')->willReturn($event);

        $relayBuilder->newInstance([])->willReturn(
            function (ServerRequestInterface $req, ResponseInterface $res) {
                return $res;
            }
        );

        $container->offsetGet('ServerResponder')->willReturn($serverResponder);

        $serverResponder->send($response)->shouldBeCalled();

        $this->handleRequest($swoole_req, $swoole_res);
    }

    public function it_should_throw_exception_when_given_invalid_middleware_dispatcher(
        \swoole_http_request $swoole_req,
        \swoole_http_response $swoole_res,
        ServerRequestInterface $request,
        ResponseInterface $response,
        RelayBuilder $relayBuilder,
        ContainerInterface $container
    ) {
        unset($GLOBALS['_COOKIE']);
        unset($GLOBALS['_GET']);
        unset($GLOBALS['_POST']);
        unset($GLOBALS['_FILES']);

        $container->offsetSet('SwooleResponder', $swoole_res)->shouldBeCalled();

        $container->offsetGet('Request')->willReturn($request);
        $container->offsetGet('Response')->willReturn($response);

        $container->offsetGet('RelayBuilder')->willReturn($relayBuilder);

        $container->offsetGet('Middlewares')->willReturn([]);

        $relayBuilder->newInstance([])->willReturn(null);

        $this->shouldThrow('\RuntimeException')->duringHandleRequest($swoole_req, $swoole_res);
    }
}
