<?php

namespace App\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class User extends Controller
{
    public function index(Request $request, Response $response, $args)
    {
        $name = $args['name'] ?? "toto";
        $response->getBody()->write("Hello $name");

        return $response;
    }
}