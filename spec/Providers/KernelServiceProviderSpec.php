<?php

namespace spec\Vinnige\Providers;

use Illuminate\Container\Container;
use PHPixie\HTTP;
use PHPixie\HTTP\Messages\Message\Response;
use PHPixie\HTTP\Messages\Stream\StringStream;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Lib\Config\Config;
use Vinnige\Lib\Container\LaravelContainer;

class KernelServiceProviderSpec extends ObjectBehavior
{
    private $container;

    public function let()
    {
        $this->container = new LaravelContainer(new Container());
        $this->container['Config'] = new Config([
            'http.streams' => [
                StringStream::class => ''
            ],
            'http.response' => [
                'class' => Response::class,
                'protocol.version' => '1.1',
                'header' => [],
                'stream' => StringStream::class
            ],
        ]);

        $this->beConstructedWith();

        $this->register($this->container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Providers\KernelServiceProvider');
    }

    public function it_should_return_http_message()
    {
        $this->container['Http'];
    }

    public function it_should_return_request(HTTP $http)
    {
        $this->container['Http'] = $http;
        $this->container['Request'];
    }

    public function it_should_return_response()
    {
        $this->container['Response'];
    }

    public function it_should_return_event_dispatcher()
    {
        $this->container['EventDispatcher'];
    }

    public function it_should_able_to_register_event_listener(
        ContainerInterface $container,
        EventDispatcherInterface $event
    ) {
        $this->subscribe($container, $event);
    }
}
