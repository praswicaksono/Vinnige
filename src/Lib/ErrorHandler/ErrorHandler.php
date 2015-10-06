<?php

namespace Vinnige\Lib\ErrorHandler;

use Psr\Http\Message\ResponseInterface;
use Vinnige\Contracts\ContainerInterface;
use Vinnige\Lib\Http\Exceptions\HttpException;
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
        if ($this->app['Config']->offsetExists('debug')
            && $this->app['Config']->offsetGet('debug') === true) {
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
        } else {
            $this->writeToOutput('whoops something went wrong');
        }
    }

    /**
     * @param \Exception|HttpException $exception
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function handleException(\Exception $exception)
    {
        $code = 500;
        $contentType = 'application/json';

        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
        }

        if ($this->app['Config']->offsetExists('debug')
            && $this->app['Config']->offsetGet('debug') === true) {
            $contentType = 'text/html';
        }

        ob_start();
        $this->whoops->handleException($exception);
        $html = ob_get_clean();

        $this->writeToOutput($html, $code, $contentType);
    }

    /**
     * @param string $content
     * @param int $code
     * @param string $contentType
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    private function writeToOutput($content = '', $code = 500, $contentType = 'text/html')
    {
        /**
         * @var ResponseInterface $response
         */
        $response = $this->app['Response'];
        $response->getBody()->write($content);

        $response = $response->withStatus($code)->withHeader('Content-Type', $contentType);

        $this->app['ServerResponder']->send($response);
    }
}
