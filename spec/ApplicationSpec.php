<?php

namespace spec\Vinnige;

use FastRoute\RouteCollector;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Vinnige\Contracts\ConfigurationInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\EventSubscriberAwareServiceProvider;
use Vinnige\Contracts\MiddlewareInterface;
use Vinnige\Contracts\ServerInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Vinnige\Stub\NotValidMiddlewareClass;

class ApplicationSpec extends ObjectBehavior
{
    public function let(ConfigurationInterface $config, ContainerInterface $container)
    {
        $container->offsetSet('Config', $config)->shouldBeCalled();
        $container->offsetSet('Container', $container)->shouldBeCalled();
        $container->bind('Vinnige\Contracts\ContainerInterface', 'Container')->shouldBeCalled();
        $container->bind('Vinnige\Contracts\ConfigurationInterface', 'Config')->shouldBeCalled();
        $this->beConstructedWith($config, $container);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Vinnige\Application');
        $this->shouldImplement('Vinnige\Contracts\ContainerInterface');
    }

    public function it_should_able_forget_instance(ContainerInterface $container, ConfigurationInterface $config)
    {
        $container->offsetUnset('Key')->shouldBeCalled();
        $this->offsetUnset('Key');
    }

    public function it_should_able_register_singleton_instance(ContainerInterface $container)
    {
        $container->singleton('Test', null)->shouldBeCalled();

        $this->singleton('Test');
    }

    public function it_should_able_to_get_static_container_instance()
    {
        static::getInstance()->shouldReturn(null);
    }

    public function it_should_able_bind_object_to_container(
        ContainerInterface $container
    ) {
        $container->bind('test', 'test')->shouldBeCalled();
        $this->bind('test', 'test');
    }
    public function it_should_have_get_method()
    {
        $this->get('/', function () {})->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_have_post_method()
    {
        $this->post('/', function () {})->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_have_put_method()
    {
        $this->put('/', function () {})->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_have_delete_method()
    {
        $this->delete('/', function () {})->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_able_to_register_service_provider(
        ServiceProviderInterface $service,
        ContainerInterface $container,
        ConfigurationInterface $config
    ) {
        $container->offsetGet('Config')->willReturn($config);
        $this->register($service, [])->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_able_to_register_event_subscriber_aware_service_provider(
        EventSubscriberAwareServiceProvider $service,
        ContainerInterface $container,
        ConfigurationInterface $config,
        EventDispatcherInterface $event
    ) {
        $container->offsetGet('Config')->willReturn($config);
        $container->offsetGet('EventDispatcher')->willReturn($event);
        $this->register($service, [])->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_able_to_register_callable_middleware()
    {
        $this->middleware(function () {})->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_able_to_register_class_name_as_middleware(ContainerInterface $container)
    {
        $container->singleton(NotValidMiddlewareClass::class)->shouldBeCalled();

        $this->middleware(NotValidMiddlewareClass::class);
    }

    public function it_should_able_to_register_object_middleware(
        MiddlewareInterface $middleware,
        ContainerInterface $container
    ) {
        $container->singleton($middleware)->shouldBeCalled();
        $this->middleware($middleware)->shouldReturnAnInstanceOf('Vinnige\Application');
    }

    public function it_should_throw_exception_when_given_object_that_not_implement_middleware_contract()
    {
        $this->shouldThrow('\RuntimeException')->duringMiddleware(new NotValidMiddlewareClass());
    }

    public function it_should_throw_exception_when_given_non_callable_middleware()
    {
        $this->shouldThrow('\RuntimeException')->duringMiddleware('SomeString');
    }

    public function it_should_throw_exception_during_register_server_event_when_there_are_server_in_container(
        ContainerInterface $container,
        ConfigurationInterface $config
    ) {
        $container->offsetSet('Config', $config)->shouldBeCalled();
        $container->offsetExists('Server')->willReturn(false);

        $this->shouldThrow('\RuntimeException')->duringServerEvent('event', function () {});
    }

    public function it_should_able_register_server_event(
        ContainerInterface $container,
        ServerInterface $server,
        ConfigurationInterface $config
    ) {
        $func = function () {};
        $container->offsetExists('Server')->willReturn(true);
        $container->offsetGet('Server')->willReturn($server);
        $server->on('event', $func)->shouldBeCalled();

        $this->serverEvent('event', $func);
    }

    public function it_should_able_to_retreive_registered_middleware()
    {
        $this->getMiddlewares()->shouldReturn([]);
    }

    public function it_should_able_to_retrieve_registered_service_provider()
    {
        $this->getServiceProviders()->shouldReturn([]);
    }

    public function it_should_able_to_retrieve_registered_routes()
    {
        $this->getRoutes()->shouldReturn([]);
    }

    public function it_should_able_to_run(
        ContainerInterface $container,
        RouteCollector $collector,
        ServerInterface $server
    ) {
        /**
         * predictions
         */
        $container->offsetSet('Middlewares', [])->shouldBeCalled();
        $container->offsetSet('ServiceProviders', [])->shouldBeCalled();
        $container->offsetSet('Routes', [])->shouldBeCalled();
        $collector->addRoute('GET', '/', 'test')->shouldBeCalled();
        $server->run()->shouldBeCalled();

        /**
         * mocks
         */
        $container->offsetGet('Routes')->willReturn([[
            'method' => 'GET',
            'route' => '/',
            'handler' => 'test'
        ]]);
        $container->offsetGet('Server')->willReturn($server);
        $container->offsetGet('RouteCollector')->willReturn($collector);

        /**
         * test method
         */
        $this->run();
    }
}
