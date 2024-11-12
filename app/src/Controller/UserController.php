<?php

namespace App\Controller;

use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use App\Service\UserService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use OpenApi\Attributes as OA;
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
    #[OA\Post(path: '/users', tags: ['Users'])]
    #[OA\RequestBody(content: new OA\JsonContent(
        examples: [
            new OA\Examples(example: "User", summary: "User test", value: [
                "email" => "test@test.com",
                "firstName" => "test",
                "lastName" => "test",
            ])
        ],
        properties: [
            new OA\Property('email', type: 'string'),
            new OA\Property('firstName', type: 'string'),
            new OA\Property('lastName', type: 'string'),
        ]
    ))]
    #[OA\Response(response: '201', description: 'User created')]
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
    #[OA\Delete(path: '/users/{email}', tags: ['Users'])]
    #[OA\Parameter(name: 'email', in: 'path', required: true)]
    #[OA\Response(response: '204', description: 'User deleted')]
    public function deleteUser(Request $request, Response $response, $args): Response
    {
        try {
            $this->userService->deleteUser($args['email']);
        } catch (UserNotFoundException $e) {
            throw new HttpNotFoundException($request, $e->getMessage(), $e);
        }

        return $response->withStatus(204);
    }

    /**
     * @throws NonUniqueResultException
     */
    #[OA\Get(path: '/users/{email}/stats', tags: ['Users'])]
    #[OA\Parameter(name: 'email', in: 'path', required: true)]
    #[OA\Response(
        response: '200',
        description: 'User stats',
        content: new OA\JsonContent(properties: [
            new OA\Property('charges', type: 'integer'),
            new OA\Property('totalEnergyConsumed', type: 'integer'),
            new OA\Property('averageCost', type: 'float'),
        ])
    )]
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