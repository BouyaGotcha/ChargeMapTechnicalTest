<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->get('/', function (RequestInterface $request, ResponseInterface $response, array $args) {
    $response->getBody()->write('Hello from sdf');
    return $response;
});

$app->run();
