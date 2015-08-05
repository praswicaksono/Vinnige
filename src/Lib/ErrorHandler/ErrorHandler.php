<?php

namespace Vinnige\Lib\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Vinnige\Contracts\ContainerInterface;
use Whoops\Exception\ErrorException;
use Whoops\Run;

/**
 * Class ErrorHandler
 * @package Vinnige\Lib\ErrorHandler
 */
class ErrorHandler
{
    /**
     * @var ContainerInterface
     */
    private $app;

    /**
     * @var Run
     */
    private $whoops;

    /**
     * @param ContainerInterface $app
     * @param Run $whoops
     */
    public function __construct(ContainerInterface $app, Run $whoops = null)
    {
        $this->app = $app;
        $this->whoops = $whoops;
    }

    /**
     * handle shut down function
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function handleError()
    {
        if ($this->app['Config']->offsetExists('debug')) {
            $error = error_get_last();

            $exception = new ErrorException(
                $error['message'],
                $error['type'],
                $error['type'],
                $error['file'],
                $error['line']
            );

            ob_start();
            $this->whoops->handleException($exception);
            $html = ob_get_clean();

            $this->writeToOutput($html);
        }
    }

    /**
     * @param \Exception $exception
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function handleException(\Exception $exception)
    {
        ob_start();
        $this->whoops->handleException($exception);
        $html = ob_get_clean();

        $this->writeToOutput($html);
    }

    /**
     * @param string $content
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    private function writeToOutput($content = '')
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->app['Response'];
        $response->getBody()->write($content);
        $response->withHeader('Content-Type', 'text/html');

        $this->app['ServerResponder']->send($response);
    }
}
