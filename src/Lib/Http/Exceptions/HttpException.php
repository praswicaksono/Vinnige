<?php


namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class HttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class HttpException extends \RuntimeException
{
    /**
     * @var int $http_status_code
     */
    private $http_status_code;

    /**
     * @var array $headers
     */
    private $headers = [];

    /**
     * @param string $status_code
     * @param string $message
     * @param array $headers
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($status_code, $message = "", $headers = [], $code = 0, \Exception $previous = null)
    {
        $this->http_status_code = $status_code;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->http_status_code;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
