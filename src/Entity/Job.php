<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\JobRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobRepository::class)]
class Job
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank()]
    #[Assert\Length(
        min: 2,
        max: 50,
        minMessage: 'Le nom du métier doit comporter au moins {{ limit }} caractères',
        maxMessage: 'Le nom du métier ne peut pas dépasser {{ limit }} caractères.',
    )]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Specialist::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Specialist $category = null;

    #[ORM\Column(type: 'string')]
    private ?string $location = null;

    #[ORM\Column(type: 'string')]
    private ?string $biography = null;

    #[ORM\OneToMany(targetEntity: Review::class, mappedBy: 'job')]
    private $reviews;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getCategory(): ?Specialist
    {
        return $this->category;
    }

    public function setCategory(Specialist $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;
        return $this;
    }

    public function getBiography(): ?string
    {
        return $this->biography;
    }

    public function setBiography(string $biography): self
    {
        $this->biography = $biography;
        return $this;
    }

    public function getReviews()
    {
        return $this->reviews;
    }
}