<?php

namespace App\Tests\Service;

use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    private EntityManager $entityManager;
    private UserRepository $userRepository;
    private array $data = [];

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManager::class);
        $this->userRepository = $this->createMock(UserRepository::class);

        $this->data = [
            "email" => "test@test.com",
            "firstName" => "Test",
            "lastName" => "User",
        ];
    }

    public function testCreateUser()
    {
        $userService = new UserService($this->entityManager, $this->userRepository);
        $user = $userService->createUser($this->data);

        $this->assertEquals($this->data["email"], $user->getEmail());
        $this->assertEquals($this->data["firstName"], $user->getFirstName());
        $this->assertEquals($this->data["lastName"], $user->getLastName());
    }
}