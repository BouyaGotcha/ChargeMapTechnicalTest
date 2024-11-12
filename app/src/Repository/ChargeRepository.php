<?php

namespace App\Repository;

use Doctrine\ORM\EntityManagerInterface;

class ChargeRepository
{

    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

}