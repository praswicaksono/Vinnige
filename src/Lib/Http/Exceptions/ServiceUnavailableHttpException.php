<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class ServiceUnavailableHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class ServiceUnavailableHttpException extends HttpException
{
    /**
     * @param int $retry_after
     * @param string $messages
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($retry_after = 0, $messages = '', $code = 0, \Exception $previous = null)
    {
        $headers = [];

        if ($retry_after) {
            $headers = ['Retry-After' => $retry_after];
        }

        parent::__construct(503, $messages, $headers, $code, $previous);
    }
}
