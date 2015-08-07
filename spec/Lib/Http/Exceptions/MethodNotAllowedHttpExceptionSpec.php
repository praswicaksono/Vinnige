<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodNotAllowedHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['GET', 'POST']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\MethodNotAllowedHttpException');
    }

    public function it_should_return_method_not_allowed_http_code()
    {
        $this->getStatusCode()->shouldReturn(405);
    }

    public function it_should_return_allowed_header()
    {
        $this->getHeaders()->shouldReturn(['Allow' => 'GET,POST']);
    }
}
