<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class UnsupportedMediaTypeHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class UnsupportedMediaTypeHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(415, $message, [], $code, $previous);
    }
}
