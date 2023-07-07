<?php

namespace App\Entity;

use App\Repository\ExoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExoRepository::class)]
class Exo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?int $niveau = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pathologie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $age_maladie = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $vivre_quatidien = null;

    #[ORM\OneToMany(mappedBy: 'exoUsers', targetEntity: User::class, cascade: ['persist'])]
    private Collection $userLists;

    #[ORM\Column(type: 'bigint', nullable: true)]
    private ?string $quel_age = null;

    public function __construct()
    {
        $this->userLists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getNiveau(): ?int
    {
        return $this->niveau;
    }

    public function setNiveau(int $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPathologie(): ?string
    {
        return $this->pathologie;
    }

    public function setPathologie(string $pathologie): static
    {
        $this->pathologie = $pathologie;

        return $this;
    }

    public function getAgeMaladie(): ?string
    {
        return $this->age_maladie;
    }

    public function setAgeMaladie(string $age_maladie): static
    {
        $this->age_maladie = $age_maladie;

        return $this;
    }

    public function getVivreQuatidien(): ?string
    {
        return $this->vivre_quatidien;
    }

    public function setVivreQuatidien(?string $vivre_quatidien): static
    {
        $this->vivre_quatidien = $vivre_quatidien;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUserLists(): Collection
    {
        return $this->userLists;
    }

    public function addUserList(User $userList): static
    {
        if (!$this->userLists->contains($userList)) {
            $this->userLists->add($userList);
            $userList->setExoUsers($this);
        }

        return $this;
    }

    public function removeUserList(User $userList): static
    {
        if ($this->userLists->removeElement($userList)) {
            // set the owning side to null (unless already changed)
            if ($userList->getExoUsers() === $this) {
                $userList->setExoUsers(null);
            }
        }

        return $this;
    }

    public function getQuelAge(): ?string
    {
        return $this->quel_age;
    }

    public function setQuelAge(?string $quel_age): static
    {
        $this->quel_age = $quel_age;

        return $this;
    }
}
