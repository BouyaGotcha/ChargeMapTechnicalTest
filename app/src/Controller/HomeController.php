<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{

    public function index(Request $request, Response $response, $args): Response
    {
        $response->getBody()->write("Home page");

        return $response->withStatus(200);
    }

}