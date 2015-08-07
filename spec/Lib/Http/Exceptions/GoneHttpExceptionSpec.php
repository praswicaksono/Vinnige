<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class GoneHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('gone');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\GoneHttpException');
    }

    public function it_should_return_gone_http_code()
    {
        $this->getStatusCode()->shouldReturn(410);
    }
}
