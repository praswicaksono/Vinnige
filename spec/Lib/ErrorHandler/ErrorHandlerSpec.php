<?php

namespace spec\Vinnige\Lib\ErrorHandler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Log\LoggerInterface;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServerResponderInterface;
use Whoops\Handler\HandlerInterface;
use Whoops\Run;

class ErrorHandlerSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container, Run $whoops, HandlerInterface $handler)
    {
        $this->beConstructedWith($container, $whoops, $handler);
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
        LoggerInterface $logger,
        ServerResponderInterface $serverResponder
    ) {
        $container->offsetGet('Config')->willReturn($config);
        $container->offsetGet('Response')->willReturn($response);
        $container->offsetGet('ServerResponder')->willReturn($serverResponder);
        $container->offsetGet('Logger')->willReturn($logger);

        $response->getBody()->willReturn($stream);
        $response->withHeader('Content-Type', 'text/html')->willReturn($response);
        $response->withStatus('500')->willReturn($response);

        $config->offsetExists('debug')->willReturn(true);
        $config->offsetGet('debug')->willReturn(true);

        $this->handleError();
    }

    public function it_should_able_handle_exception(
        ContainerInterface $container,
        ResponseInterface $response,
        StreamInterface $stream,
        ServerResponderInterface $serverResponder,
        ConfigurationInterface $config,
        StreamInterface $stream,
        LoggerInterface $logger,
        \Exception $e
    ) {
        $container->offsetGet('Response')->willReturn($response);
        $container->offsetGet('ServerResponder')->willReturn($serverResponder);
        $container->offsetGet('Logger')->willReturn($logger);
        $container->offsetGet('Config')->willReturn($config);

        $response->getBody()->willReturn($stream);
        $response->withHeader('Content-Type', 'text/html')->willReturn($response);
        $response->withStatus('500')->willReturn($response);

        $this->handleException($e);
    }
}
