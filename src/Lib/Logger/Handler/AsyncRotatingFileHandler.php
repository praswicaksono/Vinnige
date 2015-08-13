<?php

namespace Vinnige\Lib\Logger\Handler;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class AsyncRotatingFileHandler
 * @package Vinnige\Lib\Logger\Handler
 */
class AsyncRotatingFileHandler extends AbstractProcessingHandler
{
    /**
     * @var string
     */
    private $logDir;

    /**
     * @param string $logDir
     * @param bool|int $level
     * @param bool|true $bubble
     */
    public function __construct($logDir, $level = Logger::DEBUG, $bubble = true)
    {
        $this->logDir = $logDir;

        parent::__construct((int)$level, $bubble);
    }

    /**
     * write asynchronously to file
     * @param array $record
     * @throws \UnexpectedValueException
     */
    protected function write(array $record)
    {
        if (!is_dir($this->logDir)) {
            $this->createDir();
        }

        $filename = $this->logDir . '/' . date('Y-m-d') . '.log';

        swoole_async_write($filename, (string)$record['formatted'], -1);
    }

    /**
     * create directory
     * @throws \UnexpectedValueException
     */
    private function createDir()
    {
        $status = mkdir($this->logDir, 0777, true);

        if ($status === false) {
            throw new \UnexpectedValueException(sprintf('%s is not valid directory', $this->logDir));
        }
    }
}
