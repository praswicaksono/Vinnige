<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AccessDeniedHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('access denied');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\AccessDeniedHttpException');
    }

    public function it_should_return_access_denied_http_code()
    {
        $this->getStatusCode()->shouldReturn(403);
    }
}
