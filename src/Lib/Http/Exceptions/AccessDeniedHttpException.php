<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class AccessDeniedHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class AccessDeniedHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(403, $message, [], $code, $previous);
    }
}

