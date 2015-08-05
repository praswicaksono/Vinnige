<?php

namespace Vinnige\Providers;

use Vinnige\Contracts\ContainerInterface;
use Vinnige\Contracts\ServiceProviderInterface;
use Vinnige\Lib\ErrorHandler\ErrorHandler;
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
                if ($this->app['Config']->offsetExists('debug')) {
                    $pageHandler = new PrettyPageHandler();
                    $pageHandler->handleUnconditionally(true);

                    $this->whoops = new Run();
                    $this->whoops->allowQuit(false);
                    $this->whoops->pushHandler($pageHandler);

                    return new ErrorHandler($this->app, $this->whoops);
                } else {
                    return new ErrorHandler($this->app, null);
                }
            }
        );

        /**
         * catch fatal error
         */
        register_shutdown_function([$this->app['ErrorHandler'], 'handleError']);
    }
}
