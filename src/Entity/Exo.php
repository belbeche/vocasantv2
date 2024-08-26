<?php

namespace App\Entity;

use App\Repository\ExoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;

#[ORM\Entity(repositoryClass: ExoRepository::class)]
class Exo
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'exoUsers')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $autonomyLevel = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathologie = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $ageMaladie = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $quelAge = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeHpi = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $difficultes = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $autonomie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vivreQuotidien = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getAutonomyLevel(): ?int
    {
        return $this->autonomyLevel;
    }

    public function setAutonomyLevel(?int $autonomyLevel): self
    {
        $this->autonomyLevel = $autonomyLevel;

        return $this;
    }

    public function getPathologie(): ?string
    {
        return $this->pathologie;
    }

    public function setPathologie(?string $pathologie): self
    {
        $this->pathologie = $pathologie;

        return $this;
    }

    public function getAgeMaladie(): ?int
    {
        return $this->ageMaladie;
    }

    public function setAgeMaladie(?int $ageMaladie): self
    {
        $this->ageMaladie = $ageMaladie;

        return $this;
    }

    public function getQuelAge(): ?int
    {
        return $this->quelAge;
    }

    public function setQuelAge(?int $quelAge): self
    {
        $this->quelAge = $quelAge;

        return $this;
    }

    public function getTypeHpi(): ?string
    {
        return $this->typeHpi;
    }

    public function setTypeHpi(?string $typeHpi): self
    {
        $this->typeHpi = $typeHpi;

        return $this;
    }

    public function getDifficultes(): ?string
    {
        return $this->difficultes;
    }

    public function setDifficultes(?string $difficultes): self
    {
        $this->difficultes = $difficultes;

        return $this;
    }

    public function getAutonomie(): ?string
    {
        return $this->autonomie;
    }

    public function setAutonomie(?string $autonomie): self
    {
        $this->autonomie = $autonomie;

        return $this;
    }

    public function getVivreQuotidien(): ?string
    {
        return $this->vivreQuotidien;
    }

    public function setVivreQuotidien(?string $vivreQuotidien): self
    {
        $this->vivreQuotidien = $vivreQuotidien;

        return $this;
    }
}
