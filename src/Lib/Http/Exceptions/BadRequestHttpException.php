<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class BadRequestHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class BadRequestHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(400, $message, [], $code, $previous);
    }
}
