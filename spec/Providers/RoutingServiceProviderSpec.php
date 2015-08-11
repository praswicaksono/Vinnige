<?php

namespace spec\Vinnige\Providers;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vinnige\Lib\Container\LaravelContainer;

class RoutingServiceProviderSpec extends ObjectBehavior
{
    private $container;

    public function let()
    {
        $this->container = new LaravelContainer(new Container());

        $this->beConstructedWith();

        $this->register($this->container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Providers\RoutingServiceProvider');
    }

    public function it_should_able_resolve_instance()
    {
        $this->container['RouteParser'];
        $this->container['DataGenerator'];
        $this->container['RouteCollector'];
        $this->container['RouteDispatcher'];
    }
}
