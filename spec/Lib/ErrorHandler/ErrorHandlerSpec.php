<?php

namespace spec\Vinnige\Lib\ErrorHandler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerResponderInterface;
use Whoops\Run;

class ErrorHandlerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container, Run $whoops)
    {
        $this->beConstructedWith($container, $whoops);
    }
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\ErrorHandler\ErrorHandler');
    }

    public function it_should_able_handle_error(
        ContainerInterface $container,
        ConfigurationInterface $config,
        ResponseInterface $response,
        StreamInterface $stream,
        ServerResponderInterface $serverResponder
    ) {
        $container->offsetGet('Config')->willReturn($config);
        $container->offsetGet('Response')->willReturn($response);
        $container->offsetGet('ServerResponder')->willReturn($serverResponder);

        $response->getBody()->willReturn($stream);
        $response->withHeader('Content-Type', 'text/html')->shouldBeCalled();

        $config->offsetExists('debug')->willReturn(true);
        $config->offsetGet('debug')->willReturn(true);

        $this->handleError();
    }

    public function it_should_able_handle_exception(
        ContainerInterface $container,
        ResponseInterface $response,
        StreamInterface $stream,
        ServerResponderInterface $serverResponder,
        \Exception $e
    ) {
        $container->offsetGet('Response')->willReturn($response);
        $container->offsetGet('ServerResponder')->willReturn($serverResponder);

        $response->getBody()->willReturn($stream);
        $response->withHeader('Content-Type', 'text/html')->shouldBeCalled();

        $this->handleException($e);
    }
}
