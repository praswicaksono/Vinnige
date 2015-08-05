<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class TooManyRequestHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class TooManyRequestHttpException extends HttpException
{
    /**
     * @param int $retry_after
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($retry_after = 0, $message = '', $code = 0, \Exception $previous = null)
    {
        $headers = [];

        if ($retry_after) {
            $headers = ['Retry-After' => $retry_after];
        }

        parent::__construct(429, $message, $headers, $code, $previous);
    }
}
