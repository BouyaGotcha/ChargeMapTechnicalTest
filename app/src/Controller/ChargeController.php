<?php

namespace App\Controller;

use App\Repository\ChargeRepository;
use Doctrine\ORM\EntityManager;

class ChargeController
{
    public function __construct(
        private readonly EntityManager    $entityManager,
        private readonly ChargeRepository $userRepository
    )
    {
    }
}