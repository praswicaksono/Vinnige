<?php

namespace Vinnige\Providers;

use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Vinnige\Lib\ErrorHandler\ErrorHandler;
use Whoops\Handler\HandlerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

/**
 * Class ErrorHandlerProvider
 * @package Vinnige\Providers
 */
class ErrorHandlerProvider implements ServiceProviderInterface
{
    /**
     * @var Run
     */
    private $whoops;

    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @var HandlerInterface
     */
    private $errorHandler;

    /**
     * @param HandlerInterface $handler
     */
    public function __construct(HandlerInterface $handler)
    {
        $this->errorHandler = $handler;
    }

    /**
     * @param ContainerInterface $application
     * @throws \InvalidArgumentException
     */
    public function register(ContainerInterface $application)
    {
        $this->app = $application;

        /**
         * register whoops when debug mode enabled
         */
        $this->app->singleton(
            [
                ErrorHandler::class => 'ErrorHandler'
            ],
            function () {
                if ($this->app['Config']->offsetExists('debug')
                    && $this->app['Config']->offsetGet('debug') === true
                ) {
                    $this->errorHandler = new PrettyPageHandler();
                    $this->errorHandler->handleUnconditionally(true);
                }
                $this->whoops = new Run();
                $this->whoops->allowQuit(false);
                $this->whoops->pushHandler($this->errorHandler);

                return new ErrorHandler($this->app, $this->whoops);
            }
        );

        /**
         * catch fatal error
         */
        register_shutdown_function([$this->app['ErrorHandler'], 'handleError']);
    }
}
