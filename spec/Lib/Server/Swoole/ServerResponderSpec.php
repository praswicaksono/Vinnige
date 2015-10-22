<?php

namespace spec\Vinnige\Lib\Server\Swoole;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;

class ServerResponderSpec extends ObjectBehavior
{
    public function let(ContainerInterface $container)
    {
        $this->beConstructedWith($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Server\Swoole\ServerResponder');
    }

    public function it_should_able_send_output_to_client(
        ContainerInterface $container,
        ResponseInterface $response,
        \swoole_http_response $swoole_res,
        ConfigurationInterface $config
    ) {
        $response->getHeaders()->willReturn(
            [
                'Content-Type' => ['text/html']
            ]
        );

        $container->offsetGet('SwooleResponder')->willReturn($swoole_res);
        $swoole_res->header('Content-Type', 'text/html')->shouldBeCalled();

        $container->offsetGet('Config')->willReturn($config);
        $config->offsetExists('server.gzip')->willReturn(true);
        $config->offsetGet('server.gzip')->willReturn(3);

        $swoole_res->gzip(3)->shouldBeCalled();
        $swoole_res->status(200)->shouldBeCalled();

        $swoole_res->header('Server', 'vinnige-app-server')->shouldBeCalled();

        $response->getBody()->willReturn('hello world');
        $response->getStatusCode()->willReturn(200);

        $swoole_res->end('hello world')->shouldBeCalled();

        $this->send($response);

    }
}
