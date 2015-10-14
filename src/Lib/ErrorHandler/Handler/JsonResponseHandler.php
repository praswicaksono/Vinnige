<?php

namespace Vinnige\Lib\ErrorHandler\Handler;

use Whoops\Handler\Handler;

/**
 * Class JsonResponseHandler
 * @package Vinnige\Lib\ErrorHandler\Handler
 */
class JsonResponseHandler extends Handler
{
    const CONTENT_TYPE = 'application/json';

    /**
     * @return int
     */
    public function handle()
    {
        $response = [
            'error_message' => $this->getException()->getMessage()
        ];

        echo json_encode($response);

        return Handler::QUIT;
    }
}
