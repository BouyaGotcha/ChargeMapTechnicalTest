<?php

namespace App\Domain\Entity;

use App\Repository\ChargeRepository;
use DateTime;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\CustomIdGenerator;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\Doctrine\UuidGenerator;

#[Entity(repositoryClass: ChargeRepository::class, readOnly: false)]
#[Table(name: "charges")]
class Charge
{
    #[Id, Column(
        type: "uuid"),
        GeneratedValue(strategy: "CUSTOM"),
        CustomIdGenerator(class: UuidGenerator::class)
    ]
    protected ?string $uuid = null;

    #[Column(name: "energy_consumed", type: "integer")]
    protected ?int $energyConsumed = null;

    #[Column(type: "integer")]
    protected ?int $cost = null;

    #[Column(name: "created_at", type: "datetime")]
    protected ?DateTime $createdAt = null;

    #[Column(type: "boolean")]
    protected ?bool $succeeded = null;

    #[ManyToOne(targetEntity: "User", cascade: ["all"], fetch: "EAGER")]
    protected ?User $user = null;

    public function __construct($energyConsumed, $cost, $succeeded, User $user)
    {
        $this->energyConsumed = $energyConsumed;
        $this->cost = $cost;
        $this->succeeded = $succeeded;
        $this->user = $user;

        $this->createdAt = new DateTime();
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): Charge
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getEnergyConsumed(): ?int
    {
        return $this->energyConsumed;
    }

    public function setEnergyConsumed(?int $energyConsumed): Charge
    {
        $this->energyConsumed = $energyConsumed;
        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(?int $cost): Charge
    {
        $this->cost = $cost;
        return $this;
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTime $createdAt): Charge
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getSucceeded(): ?bool
    {
        return $this->succeeded;
    }

    public function setSucceeded(?bool $succeeded): Charge
    {
        $this->succeeded = $succeeded;
        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): Charge
    {
        $this->user = $user;
        return $this;
    }
}