<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LengthRequiredHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('length required');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\LengthRequiredHttpException');
    }

    public function it_should_return_length_required_http_code()
    {
        $this->getStatusCode()->shouldReturn(411);
    }
}
