<?php

namespace App\Domain\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;

#[Entity(repositoryClass: UserRepository::class, readOnly: false)]
#[Table(name: "users")]
#[UniqueConstraint(name: "email", columns: ["email"])]
class User
{
    #[Id, Column(type: "integer"), GeneratedValue(strategy: "IDENTITY")]
    protected ?int $id = null;

    #[Column(type: "string", length: 255)]
    protected ?string $email = null;

    #[Column(type: "string", length: 255)]
    protected ?string $firstName = null;

    #[Column(type: "string", length: 255)]
    protected ?string $lastName = null;
}
