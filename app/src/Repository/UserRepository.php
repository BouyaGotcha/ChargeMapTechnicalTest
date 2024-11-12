<?php

namespace App\Repository;

use App\Domain\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function findAll(): array
    {
        $qb = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u');

        return $qb->getQuery()->getResult();
    }

}