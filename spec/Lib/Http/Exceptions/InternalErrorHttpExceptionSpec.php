<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InternalErrorHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('internal error');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\InternalErrorHttpException');
    }

    public function it_should_return_internal_error_status_code()
    {
        $this->getStatusCode()->shouldReturn(500);
    }
}
