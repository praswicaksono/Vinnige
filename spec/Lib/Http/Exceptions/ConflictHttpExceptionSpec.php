<?php

namespace spec\Vinnige\Lib\Http\Exceptions;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConflictHttpExceptionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith('conflict');
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Http\Exceptions\ConflictHttpException');
    }

    public function it_should_return_conflict_http_code()
    {
        $this->getStatusCode()->shouldReturn(409);
    }
}
