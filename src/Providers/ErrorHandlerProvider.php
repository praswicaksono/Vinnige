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
     * @var string
     */
    private $contentType;
    /**
     * @param HandlerInterface $handler
     * @param string $contentType
     */
    public function __construct(HandlerInterface $handler, $contentType = 'text/html')
    {
        $this->errorHandler = $handler;
        $this->contentType = $contentType;
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
                if ($this->errorHandler instanceof PrettyPageHandler) {
                    $this->errorHandler->handleUnconditionally(true);
                }
                $this->whoops = new Run();
                $this->whoops->allowQuit(false);
                $this->whoops->pushHandler($this->errorHandler);

                return new ErrorHandler($this->app, $this->whoops, $this->contentType);
            }
        );

        /**
         * catch fatal error
         */
        register_shutdown_function([$this->app['ErrorHandler'], 'handleError']);
    }
}
