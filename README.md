Vinnige
===

High Performance & Non-Blocking I/O PHP Web Framework

Usage
====

Create php files for example index.php then copy code below

```php
<?php

use Vinnige\Application;
use Vinnige\Middlewares\RoutingMiddleware;
use PHPixie\HTTP\Messages\Stream\StringStream;
use PHPixie\HTTP\Messages\Message\Response;
use Vinnige\Lib\Logger\Handler\AsyncRotatingFileHandler;
use Vinnige\Lib\Config\Config;
use Vinnige\Lib\Container\LaravelContainer;
use Illuminate\Container\Container;
use Vinnige\Providers\KernelServiceProvider;
use Vinnige\Providers\MonologServiceProvider;
use Monolog\Formatter\LineFormatter;
use Vinnige\Providers\SwooleServerServiceProvider;
use Vinnige\Providers\RoutingServiceProvider;
use Vinnige\Providers\MiddlewareDispatcherServiceProvider;
use Vinnige\Providers\ErrorHandlerProvider;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;

require 'vendor/autoload.php';

$app = new Application(
    new Config(
        [
            'server.hostname' => 'localhost',
            'server.port' => 8000,
            'server.config' => [
                'worker_num' => 4,
                'reactor_thread' => 4,
                'dispatch_mode' => 2,
                'max_request' => 10000
            ],
            'debug' => true
        ]
    ),
    new LaravelContainer(new Container())
);

/**
 * default service provider
 */
$app->register(new KernelServiceProvider(), [
    'http.streams' => [
        StringStream::class => ''
    ],
    'http.response' => [
        'class' => Response::class,
        'protocol.version' => '1.1',
        'header' => [],
        'stream' => StringStream::class
    ],
]);
$app->register(new MonologServiceProvider(), [
    'logger.name' => 'vinige',
    'logger.handler' => [
        AsyncRotatingFileHandler::class => [
            'args' => [
                __DIR__
            ],
            'formatter' => [
                LineFormatter::class => []
            ]
        ]
    ]
]);

$app->register(new SwooleServerServiceProvider());
$app->register(new RoutingServiceProvider());
$app->register(new MiddlewareDispatcherServiceProvider());
$app->register(new ErrorHandlerProvider());

/**
 * register onRequest callback
 */
$app->serverEvent('request', [$app['ServerRequestHandler'], 'handleRequest']);

/**
 * define routes
 */
$app->get(
    '/hello',
    function (ServerRequestInterface $request, ResponseInterface $response) {
        $response->getBody()->write('hello world');
        return $response->withHeader('Content-Type', 'text/html');
    }
);
/**
 * default middleware
 */
$app->middleware(RoutingMiddleware::class);

/**
 * run app
 */
$app->run();
```

then run via cli

```
php index.php
```