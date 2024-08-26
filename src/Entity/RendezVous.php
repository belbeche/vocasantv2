<?php

namespace App\Entity;


use Symfony\Component\Uid\Uuid;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\RendezVousRepository;
use DateTime;

#[ORM\Entity(repositoryClass: RendezVousRepository::class)]

class RendezVous
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: "CUSTOM")]
    #[ORM\CustomIdGenerator(class: "doctrine.uuid_generator")]
    private ?Uuid $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(targetEntity: Professionnel::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Professionnel $professionnel = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTime $dateHeure = null;

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

    public function getProfessionnel(): ?Professionnel
    {
        return $this->professionnel;
    }

    public function setProfessionnel(?Professionnel $professionnel): self
    {
        $this->professionnel = $professionnel;

        return $this;
    }

    public function getDateHeure(): ?DateTime
    {
        return $this->dateHeure;
    }

    public function setDateHeure(?DateTime $dateHeure): self
    {
        $this->dateHeure = $dateHeure;

        return $this;
    }
}
