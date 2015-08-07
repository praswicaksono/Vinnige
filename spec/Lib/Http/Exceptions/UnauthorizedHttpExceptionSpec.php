<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnauthorizedHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('unauthorized');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\UnauthorizedHttpException');
    }

    public function it_should_return_unauthorized_http_code()
    {
        $this->getStatusCode()->shouldReturn(401);
    }

    public function it_should_return_www_authenticate_header()
    {
        $this->getHeaders()->shouldReturn(['WWW-Authenticate' => 'unauthorized']);
    }
}
