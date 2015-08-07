<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NotAcceptableHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('not acceptable');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\NotAcceptableHttpException');
    }

    public function it_should_return_not_acceptable_http_code()
    {
        $this->getStatusCode()->shouldReturn(406);
    }
}
