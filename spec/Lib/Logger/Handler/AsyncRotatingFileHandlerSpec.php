<?php

namespace spec\Vinnige\Lib\Logger\Handler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AsyncRotatingFileHandlerSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(__DIR__);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Logger\Handler\AsyncRotatingFileHandler');
    }
}
