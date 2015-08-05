<?php

namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class MethodNotAllowedHttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class MethodNotAllowedHttpException extends HttpException
{
    /**
     * @param array $allow
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(array $allow, $message = '', $code = 0, \Exception $previous = null)
    {
        $headers = ['Allow' => strtoupper(implode(',', $allow))];

        parent::__construct(405, $message, $headers, $code, $previous);
    }
}
