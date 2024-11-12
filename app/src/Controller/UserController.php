<?php

namespace App\Controller;

use App\Domain\Entity\User;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;

class UserController extends Controller
{
    public function __construct(
        private readonly EntityManager  $entityManager,
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function createUser(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        if (!array_key_exists('email', $body)
            || !array_key_exists('firstName', $body)
            || !array_key_exists('lastName', $body)
        ) {
            throw new HttpBadRequestException($request, 'missing parameters');
        }

        try {
            $user = new User($body['email'], $body['firstName'], $body['lastName']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new HttpBadRequestException($request, "Email already in use", $e);
        }

        return $response->withStatus(201);
    }

    public function deleteUser(Request $request, Response $response, $args)
    {

    }
}