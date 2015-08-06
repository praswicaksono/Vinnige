<?php


namespace Vinnige\Lib\Http\Exceptions;

/**
 * Class HttpException
 * @package Vinnige\Lib\Http\Exceptions
 */
class HttpException extends \RuntimeException
{
    /**
     * @var int $httpStatusCode
     */
    private $httpStatusCode;

    /**
     * @var array $headers
     */
    private $headers = [];

    /**
     * @param string $statusCode
     * @param string $message
     * @param array $headers
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct($statusCode, $message = '', $headers = [], $code = 0, \Exception $previous = null)
    {
        $this->httpStatusCode = $statusCode;
        $this->headers = $headers;

        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }
}
