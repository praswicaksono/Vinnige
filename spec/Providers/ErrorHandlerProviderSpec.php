<?php

namespace spec\Vinnige\Providers;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;

class ErrorHandlerProviderSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Providers\ErrorHandlerProvider');
        $this->shouldImplement('Vinnige\Contracts\ServiceProviderInterface');
    }
}
