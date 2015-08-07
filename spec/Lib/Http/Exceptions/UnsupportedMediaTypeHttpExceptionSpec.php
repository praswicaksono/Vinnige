<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnsupportedMediaTypeHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('unsupported media type');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\UnsupportedMediaTypeHttpException');
    }

    public function it_should_return_unsupported_media_type_http_code()
    {
        $this->getStatusCode()->shouldReturn(415);
    }
}
