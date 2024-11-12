<?php

namespace App\Controller;

use App\Exception\UserNotFoundException;
use App\Service\ChargeService;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpBadRequestException;
use OpenApi\Attributes as OA;

class ChargeController
{
    public function __construct(private readonly ChargeService $chargeService)
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    #[OA\Post(path: '/charges/{email}', tags: ['Charges'])]
    #[OA\Parameter(name: 'email', in: 'path', required: true)]
    #[OA\RequestBody(content: new OA\JsonContent(
        examples: [
            new OA\Examples(example: "Charge", summary: "Charge test", value: [
                "energyConsumed" => 50,
                "cost" => 10,
                "succeeded" => 1,
            ])
        ],
        properties: [
            new OA\Property('energyConsumed', type: 'integer'),
            new OA\Property('cost', type: 'integer'),
            new OA\Property('succeeded', type: 'boolean'),
        ]
    ))]
    #[OA\Response(response: '201', description: 'Charge created')]
    public function createCharge(Request $request, Response $response, $args): Response
    {
        $body = $request->getParsedBody();
        if (!array_key_exists('energyConsumed', $body)
            || !array_key_exists('cost', $body)
            || !array_key_exists('succeeded', $body)
        ) {
            throw new HttpBadRequestException($request, 'Missing parameters');
        }

        $this->chargeService->createChargeForUser($args['email'], $body);

        return $response->withStatus(201);
    }
}