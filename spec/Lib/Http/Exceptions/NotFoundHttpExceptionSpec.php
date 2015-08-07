<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotFoundHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('not found');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\NotFoundHttpException');
    }

    public function it_should_return_not_found_http_code()
    {
        $this->getStatusCode()->shouldReturn(404);
    }
}
