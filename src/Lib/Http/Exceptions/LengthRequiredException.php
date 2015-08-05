<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class LengthRequiredException
 * @package Vinnige\Lib\Http\Exceptions
 */
class LengthRequiredException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(411, $message, [], $code, $previous);
    }
}
