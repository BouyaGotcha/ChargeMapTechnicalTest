<?php

namespace App\Controller;

use App\Domain\Entity\User;
use App\Repository\UserRepository;
use DI\Container;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserController extends Controller
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function index(Request $request, Response $response, $args)
    {
        $this->userRepository->findAll();

        $name = $args['name'] ?? "toto";
        $response->getBody()->write("Hello $name");

        return $response;
    }
}