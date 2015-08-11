<?php

namespace spec\Vinnige\Providers;

use Illuminate\Container\Container;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Vinnige\Lib\Config\Config;
use Vinnige\Lib\Container\LaravelContainer;

class SwooleServerServiceProviderSpec extends ObjectBehavior
{
    private $container;

    public function let()
    {
       $config = new Config([
           'server.hostname' => '0.0.0.0',
           'server.port' => 8000,
           'server.config' => []
       ]);

        $this->container = new LaravelContainer(new Container());
        $this->container['EventDispatcher'] = new EventDispatcher();
        $this->container['Config'] = $config;

        $this->beConstructedWith();

        $this->register($this->container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Providers\SwooleServerServiceProvider');
    }

    public function it_should_able_resolve_intance()
    {
        $this->container['Server'];
        $this->container['ServerRequestHandler'];
        $this->container['ServerResponder'];
    }
}
