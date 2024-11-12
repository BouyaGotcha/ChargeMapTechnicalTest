<?php

namespace App\Domain\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
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

    #[Column(name: "first_name", type: "string", length: 255)]
    protected ?string $firstName = null;

    #[Column(name: "last_name", type: "string", length: 255)]
    protected ?string $lastName = null;

    #[OneToMany(mappedBy: "user", targetEntity: "Charge", cascade: ["persist", "remove"], orphanRemoval: true)]
    protected Collection|null $charges = null;

    public function __construct(
        string $email,
        string $firstName,
        string $lastName
    )
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCharges(): ?Collection
    {
        return $this->charges;
    }

    public function setCharges(?Collection $charges): User
    {
        $this->charges = $charges;
        return $this;
    }
}
