<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class NotAcceptableHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class NotAcceptableHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(406, $message, [], $code, $previous);
    }
}
