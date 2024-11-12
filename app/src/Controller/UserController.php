<?php

namespace App\Controller;

use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use App\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;

class UserController
{
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createUser(Request $request, Response $response, $args): Response
    {
        $body = $request->getParsedBody();
        if (!array_key_exists('email', $body)
            || !array_key_exists('firstName', $body)
            || !array_key_exists('lastName', $body)
        ) {
            throw new HttpBadRequestException($request, 'Missing parameters');
        }

        try {
            $this->userService->createUser($body);
        } catch (UserAlreadyExistsException $e) {
            throw new HttpBadRequestException($request, $e->getMessage(), $e);
        }

        return $response->withStatus(201);
    }

    /**
     * @throws OptimisticLockException
     * @throws NonUniqueResultException
     * @throws ORMException
     */
    public function deleteUser(Request $request, Response $response, $args): Response
    {
        try {
            $this->userService->deleteUser($args['email']);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage(), $e);
        }

        return $response->withStatus(204);
    }

    public function getStats(Request $request, Response $response, $args): Response
    {
        try {
            $stats = $this->userService->getStats($args['email']);

            $response->getBody()->write(json_encode($stats));
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage(), $e);
        }

        return $response->withStatus(200);
    }
}