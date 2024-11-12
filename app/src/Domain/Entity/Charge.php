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
}