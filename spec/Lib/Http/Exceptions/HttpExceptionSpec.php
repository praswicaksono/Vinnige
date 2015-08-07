<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(200, 'ok', ['key' => 'value']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\HttpException');
    }

    public function it_should_return_ok_http_code()
    {
        $this->getStatusCode()->shouldReturn(200);
    }

    public function it_should_return_custom_header()
    {
        $this->getHeaders()->shouldReturn(['key' => 'value']);
    }
}
