<?php

namespace App\Service;

use App\Domain\Entity\User;
use App\DTO\ChargeStats;
use App\Exception\UserAlreadyExistsException;
use App\Exception\UserNotFoundException;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;

class UserService
{
    public function __construct(
        private readonly EntityManager  $entityManager,
        private readonly UserRepository $userRepository
    )
    {
    }

    /**
     * @throws OptimisticLockException
     * @throws UserAlreadyExistsException
     * @throws ORMException
     */
    public function createUser(array $data): User
    {
        try {
            $user = new User($data['email'], $data['firstName'], $data['lastName']);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (UniqueConstraintViolationException $e) {
            throw new UserAlreadyExistsException();
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function getUserByEmail(string $email): User
    {
        $user = $this->userRepository->findOneByEmail($email);

        if (!$user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function deleteUser(string $email): void
    {
        $this->entityManager->remove($this->getUserByEmail($email));
        $this->entityManager->flush();
    }

    /**
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function getStats(string $email): ChargeStats
    {
        $user = $this->getUserByEmail($email);
        $stats = new ChargeStats();
        $totalCost = 0;

        foreach ($user->getCharges() as $charge) {
            $stats->charges++;
            $stats->totalEnergyConsumed += $charge->getEnergyConsumed();
            $totalCost += $charge->getCost();
        }
        $stats->averageCost = $totalCost / $stats->charges;

        return $stats;
    }

}