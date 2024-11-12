<?php

namespace App\Repository;

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
            ->from('App:User', 'u');

        return $qb->getQuery()->getResult();
    }

}