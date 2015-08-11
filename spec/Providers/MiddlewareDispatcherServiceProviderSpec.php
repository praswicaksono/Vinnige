<?php

namespace spec\Vinnige\Providers;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vinnige\Contracts\MiddlewareInterface;
use Vinnige\Lib\Container\LaravelContainer;
use Vinnige\Stub\NotValidMiddlewareClass;
use Vinnige\Stub\ValidMiddlewareClass;

class MiddlewareDispatcherServiceProviderSpec extends ObjectBehavior
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
        $this->shouldHaveType('Vinnige\Providers\MiddlewareDispatcherServiceProvider');
    }

    public function it_should_return_middleware_resolver()
    {
        $this->container['MiddlewareResolver'];
    }

    public function it_should_return_relay_builder()
    {
        $this->container['RelayBuilder'];
    }

    public function it_should_able_to_resolve_callable_middleware()
    {
        $func = function () {
            return true;
        };
        $this->middlewareResolver($func)->shouldReturn($func);
    }

    public function it_should_able_to_resolve_class_name()
    {
        $this->container['Middleware'] = new ValidMiddlewareClass();
        $this->register($this->container);

        $this->middlewareResolver('Middleware')->shouldReturn($this->container['Middleware']);
    }

    public function it_should_throw_exception_when_given_invalid_middleware()
    {
        $this->container['Middleware'] = new NotValidMiddlewareClass();
        $this->register($this->container);

        $this->shouldThrow('\RuntimeException')->duringMiddlewareResolver('Middleware');
    }
}
