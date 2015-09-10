<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class UnprocessedEntityHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class UnprocessableEntityHttpException extends HttpException
{
    /**
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = '', $code = 0, \Exception $previous = null)
    {
        parent::__construct(422, $message, [], $code, $previous);
    }
}
