<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class NotFoundHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class NotFoundHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct(404, $message, [], $code, $previous);
    }
}
