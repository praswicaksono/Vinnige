<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BadRequestHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('bad request');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\BadRequestHttpException');
    }

    public function it_should_return_bad_request_http_code()
    {
        $this->getStatusCode()->shouldReturn(400);
    }
}
