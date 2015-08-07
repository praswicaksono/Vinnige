<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ServiceUnavailableHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(5);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\ServiceUnavailableHttpException');
    }

    public function it_should_return_service_unavailable_http_code()
    {
        $this->getStatusCode()->shouldReturn(503);
    }

    public function it_should_return_retry_after_header()
    {
        $this->getHeaders()->shouldReturn(['Retry-After' => 5]);
    }
}
