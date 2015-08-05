<?php

namespace spec\Vinnige\Lib\Config;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(['Key' => 'Value']);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Lib\Config\Config');
        $this->shouldImplement('Vinnige\Contracts\ConfigurationInterface');
    }

    public function it_should_able_retrieve_by_key()
    {
        $this->offsetGet('Key')->shouldReturn('Value');
    }

    public function it_should_able_set_value()
    {
        $this->offsetSet('Key2', 'Value2');
        $this->offsetExists('Key2')->shouldReturn(true);
    }

    public function it_should_able_to_unset_by_key()
    {
        $this->offsetUnset('Key');
        $this->offsetExists('Key')->shouldReturn(false);
    }

    public function it_should_able_to_check_key_if_exist()
    {
        $this->offsetExists('Key')->shouldReturn(true);
    }

    public function it_should_able_merge_config()
    {
        $this->merge(['Key2' => 'Value2']);
        $this->offsetGet('Key2')->shouldReturn('Value2');
    }
}
