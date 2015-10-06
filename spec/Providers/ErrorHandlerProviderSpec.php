<?php

namespace spec\Vinnige\Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;
use Whoops\Handler\HandlerInterface;

class ErrorHandlerProviderSpec extends ObjectBehavior
{
    public function let(HandlerInterface $handler)
    {
        $this->beConstructedWith($handler);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Providers\ErrorHandlerProvider');
        $this->shouldImplement('Vinnige\Contracts\ServiceProviderInterface');
    }
}
