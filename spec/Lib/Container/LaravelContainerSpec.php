<?php

namespace spec\Vinnige\Lib\Container;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LaravelContainerSpec extends ObjectBehavior
{
    public function let(Container $container)
    {
        $this->beConstructedWith($container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Container\LaravelContainer');
        $this->shouldImplement('Vinnige\Contracts\ContainerInterface');
    }

    public function it_should_able_register_singleton_instance_to_container(Container $container)
    {
        $container->singleton('Test', 'Test')->shouldBeCalled();
        $this->singleton('Test', 'Test');
    }

    public function it_should_able_to_get_containter(Container $container)
    {
        $container->offsetGet('Test')->shouldBeCalled();

        $this->offsetGet('Test');
    }

    public function it_should_able_to_set_value_to_container(Container $container)
    {
        $container->offsetSet('Test', 'Test')->shouldBeCalled();

        $this->offsetSet('Test', 'Test');
    }

    public function it_should_able_to_check_key_existance_in_container(Container $container)
    {
        $container->offsetExists('Test')->shouldBeCalled();

        $this->offsetExists('Test');
    }

    public function it_should_able_to_forget_key_in_container(Container $container)
    {
        $container->offsetUnset('Test')->shouldBeCalled();

        $this->offsetUnset('Test');
    }

    public function it_should_able_to_bind(Container $container)
    {
        $container->bind('Test', 'Test')->shouldBeCalled();

        $this->bind('Test', 'Test');
    }
}
