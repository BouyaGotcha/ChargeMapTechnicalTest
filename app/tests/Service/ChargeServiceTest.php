<?php

namespace App\Tests\Service;

use App\Domain\Entity\User;
use App\Exception\UserNotFoundException;
use App\Service\ChargeService;
use App\Service\UserService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\OptimisticLockException;
use PHPUnit\Framework\TestCase;

class ChargeServiceTest extends TestCase
{

    private EntityManager $entityManager;
    private UserService $userService;
    private array $data = [];
    private User $user;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->userService = $this->createMock(UserService::class);

        $this->data = [
            "energyConsumed" => 10,
            "cost" => 100,
            "succeeded" => 1
        ];
        $this->user = new User(
            "test@test.com",
            "test",
            "test"
        );
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     * @throws UserNotFoundException
     * @throws NonUniqueResultException
     */
    public function testCreateChargeForUser()
    {
        $this->userService->method('getUserByEmail')->willReturn($this->user);
        $chargeService = new ChargeService($this->entityManager, $this->userService);

        $charge = $chargeService->createChargeForUser($this->user->getEmail(), $this->data);

        $this->assertEquals(10, $charge->getEnergyConsumed());
        $this->assertEquals(100, $charge->getCost());
        $this->assertEquals($this->user, $charge->getUser());
        $this->assertTrue($charge->getSucceeded());
    }
}