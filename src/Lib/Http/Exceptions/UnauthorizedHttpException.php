<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class UnauthorizedHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class UnauthorizedHttpException extends HttpException
{
    /**
     * @param string $challenge
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($challenge, $message = '', $code = 0, \Exception $previous = null)
    {
        $headers = ['WWW-Authenticate' => $challenge];

        parent::__construct(401, $message, $headers, $code, $previous);
    }
}
