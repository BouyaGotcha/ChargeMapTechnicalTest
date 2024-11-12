<?php

namespace App\Service;

use App\Domain\Entity\Charge;
use App\Exception\UserNotFoundException;
use App\Repository\ChargeRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;

class ChargeService
{

    public function __construct(
        private readonly EntityManager    $entityManager,
        private readonly UserService      $userService
    )
    {

    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function createChargeForUser($email, $data): Charge
    {
        $user = $this->userService->getUserByEmail($email);
        $charge = new Charge($data['energyConsumed'], $data['cost'], $data['succeeded'], $user);

        $this->entityManager->persist($charge);
        $this->entityManager->flush();

        return $charge;
    }

}